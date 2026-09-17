<?php

namespace Controllers;

Class Contacts {

  public static function page() {
    $data = array();

    if(!\Cache\Page::getData($data)) {
      $pagesModel = new \Models\Pages();

      $data = array(
        "seo" => $pagesModel->item_seo(7),
        "contacts" => array(
          "page" => $pagesModel->item(7),
        ),
      );

      \Cache\Page::storeData($data);
    }

    view('contacts', $data);
  }

  public static function send() {
    $form = new \Form();
    $isValid = $form->validate('contacts', array(
      "token" => array(
        "alias" => "",
        "rules" => ["csrf_token", 'required'],
      ),
      "contact-honey"  => array(
        "alias" => "",
        "rules" => ['honeyPotValue'],
      ),
      "contact-microtime"  => array(
        "alias" => "",
        "rules" => ['honeyPotMicrotime', 'required'],
      ),
      "contact-name"  => array(
        "alias" => \Lang\Dictionary::get('name'),
        "rules" => ['string', 'min:6', 'required'],
      ),
      "contact-email" => array(
        "alias" => \Lang\Dictionary::get('email'),
        "rules" => ['email', 'required'],
      ),
      "contact-tel" => array(
        "alias" => \Lang\Dictionary::get('phone'),
        "rules" => ['string', 'min:9'],
      ),
      "contact-message"  => array(
        "alias" => \Lang\Dictionary::get('message'),
        "rules" => ['string', 'required'],
      ),
    ));

    $msg = "Email: ".$_POST['contact-email'] ."\n\r";
    $msg .= "Tlf: ".$_POST['contact-tel']."\n\r\n\r";
    $msg .= "Msg: \n\r";
    $msg .= $_POST['contact-message'];

    if($isValid) {
      $data = array(
        "name" => $_POST['contact-name'],
        "url" => $_POST['url'],
        "subject" => 'Formulário de Contactos',
        "msg" => $msg,
        "contact_msg" => $_POST['contact-message'],
        "target_module" => 'site',
        "target_id" => 1,
        "from_email" => $_POST['contact-email'],
        "contact_tel" => $_POST['contact-tel'],
        //"user_id" => 28,
      );

      \Message::send($data);
    }

    redirect('/contacts');
    
  }

}