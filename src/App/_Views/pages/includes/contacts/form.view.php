<section id="contacts" class="wrapper style-bg1 fade-up">

    <div class="inner <?= $page == 'contacts' ? 'pad-top-short' : '' ?>">
      <h2><?= $contacts['page']['title'] ?></h2>

      <?php if(file_exists(__DIR__.'/map.view.php')) : ?>
      </div>
        <?php require_once __DIR__.'/map.view.php'; ?>
      <div class="inner pad-top-short">
      <?php endif; ?>

      <?php if(exists($contacts['page']['description'])) : ?>
      <p><?= nl2br($contacts['page']['description']) ?></p>
      <?php endif; ?>
      <div class="split style1">
        <section>
          <?php
            $errors = Form::getFormErrors('contacts');
          ?>
      
          <?php if (Form::formSuccess()): ?>
            <div class="form-msg success fade-up">
              <span><?= \Lang\Dictionary::get('req_contact_success') ?></span>
              <div class="btn" title="Fechar"><i class="fa fa-times" aria-hidden="true"></i></div>
            </div>
          <?php endif; ?>
          
          <?php if (!empty($errors)): ?>
            <div class="form-msg error fade-up">
              <span><?= \Lang\Dictionary::get('error_occurred_try_later') ?></span>
              <div class="btn" title="Fechar"><i class="fa fa-times" aria-hidden="true"></i></div>
            </div>
          <?php endif; ?>

          <form method="POST" action="<?= $site['baseURL'] ?>/contacts/send" enctype="multipart/form-data">
            <input type="hidden" name="token" value="<?= Form::newCSRFToken() ?>">
            <input type="hidden" name="url" value="<?= Request::shortPath() ?>">

            <div class="fields">

              <div class="field">
                <label for="contact-name"><?= \Lang\Dictionary::get('name') ?></label>
                <input type="text" id="contact-name" name="contact-name" <?php if(exists($errors['contact-name']['errors'])) {?> class="error" <?php } ?> value="<?= old('contact-name') ?>" required/>
                <?php showFormErrors($errors['contact-name']['errors']); ?>
              </div>

              <div class="field half">
                <label for="contact-email"><?= \Lang\Dictionary::get('email') ?></label>
                <input type="email" id="contact-email" name="contact-email" <?php if(exists($errors['contact-email']['errors'])) {?> class="error" <?php } ?> value="<?= old('contact-email') ?>" required/>
                <?php showFormErrors($errors['contact-email']['errors']); ?>
              </div>

              <div class="field half">
                <label for="contact-tel"><?= \Lang\Dictionary::get('phone') ?></label>
                <input type="text" id="contact-tel" name="contact-tel" <?php if(exists($errors['contact-tel']['errors'])) {?> class="error" <?php } ?> value="<?= old('contact-tel') ?>" onkeypress="return isNumber(event)"/>
                <?php showFormErrors($errors['contact-tel']['errors']); ?>
              </div>

              <div class="field">
                <label for="contact-message"><?= \Lang\Dictionary::get('message') ?></label>
                <textarea name="contact-message" id="contact-message" rows="5" <?php if(exists($errors['contact-message']['errors'])) {?> class="error" <?php } ?> required></textarea>
                <?php showFormErrors($errors['contact-message']['errors']); ?>
              </div>

              <div class="honey-val">
                <p>Ignore o campo seguinte, o mesmo serve para validação</p>
                <input type="text" name="contact-honey">
                <input type="hidden" name="contact-microtime" value="<?=microtime(true)?>">
              </div>

            </div>

            <ul class="actions align-right">
              <li>
                  <button class="button submit" type="submit" id=""><?= \Lang\Dictionary::get('send_message') ?></button>
              </li>
            </ul>
          </form>
        </section>
        <section class="info">
          <ul class="contact">

            <?php if(exists($siteInfo['address'])) : ?>
              <li>
                <h3><?= \Lang\Dictionary::get('address') ?></h3>
                <span><?= nl2br($siteInfo['address']) ?></span>
              </li>
            <?php endif; ?>

            <?php if(exists($siteInfo['emails'])) : ?>
              <li>
                <h3><?= \Lang\Dictionary::get('email_public') ?></h3>
                <?php foreach ($siteInfo['emails'] as $emailID => $email) : ?>
                  <span><?= $email['label'] ?>: <a href="mailto:<?= $email['email'] ?>" target="_blank" title="<?= $email['label'] ?>"><?= $email['email'] ?></a></span><br>
                <?php endforeach; ?>   
              </li>
            <?php endif; ?>

            <?php if(exists($siteInfo['phones'])) : ?>
              <li>
                <h3><?= \Lang\Dictionary::get('phone') ?></h3>
                <?php foreach ($siteInfo['phones'] as $phoneID => $phone) : ?>
                  <span><?= $phone['label'] ?>: <a href="tel:<?= $phone['number']['formatted'] ?>" target="_blank" title="<?= $phone['label'] ?>"><?= $phone['number']['unformatted'] ?></a></span><br>
                <?php endforeach; ?>              
              </li>
            <?php endif; ?>

            <?php if(exists($siteInfo['social'])) : ?>
            <li>
              <h3><?= \Lang\Dictionary::get('social_networks') ?></h3>
              <ul class="icons">
                <?php foreach ($siteInfo['social'] as $socialID => $social) : ?>
                  <?php if(exists($social['network'])) : ?>
                    <li>
                      <a href="<?= $social['url'] ?>" target="_blank" class="icon brands fa-<?= $social['network']['icon'] ?>">
                        <span class="label"><?= $social['network']['name'] ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                <?php endforeach; ?>  
              </ul>
            </li>
            <?php endif; ?>

            <!--
            <a target="_blank" href="https://www.zaask.pt/user/estevesweb"><img src="https://www.zaask.pt/widget?user=640244&widget=pro-findme" alt="" /></a>
            -->

          </ul>
        </section>
      </div>
    </div>
  </section>