<?php
$search_array = array('#project_name#', '#contacts_page#');
$replace_array = array($site['name'], $site['domain'].$site['baseURL'].'/contacts');
?>

<div style="
    width: 100%;
    max-width: 600px;
    display: block;
    margin: auto;
    box-sizing: border-box;    
    background: #fff;
    font-family: 'Arial';
    color: #222;
">

	<h1 style="
	    font-size: 18px;
	    text-transform: uppercase;
	    text-align: center;
	    background: #165083;
	    color: #fff;
	    margin: 0;
	    padding: 12px 24px;
	    font-weight: 600;
	"><?= str_replace($search_array, $replace_array, \Lang\Dictionary::get('signup_mailing_title')) ?></h1>

	<div style="font-size: 15px; padding: 16px;"><?= str_replace($search_array, $replace_array, nl2br(\Lang\Dictionary::get('signup_mailing_text'))) ?></div>
</div>