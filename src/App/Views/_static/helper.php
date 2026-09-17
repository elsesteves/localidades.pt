<?php

/*Helper Functions for views*/

function stdEmailListString(array $emails) {
	$i = 0;
	$str = '';
	foreach($emails as $email) {
		if ($i > 0) {
			$str .= ', ';
		}

		if (exists($email['label'])) {
			$label = $email['label'] . " (".$email['address'].")";
		} else {
			$label = $email['address'];
		}

		$str .= "<a href='mailto:".$email['address']."' title='". $label ."'>".$label."</a>";

		$i++;
	}
	return $str;
}

function stdPhoneListString(array $phones) {
	$i = 0;
	$str = '';
	foreach($phones as $phone) {
		if ($i > 0) {
			$str .= ', ';
		}

		if (exists($phone['label'])) {
			$label = $phone['label'] . " (".$phone['number'].")";
		} else {
			$label = $phone['number'];
		}

		$str .= "<a href='tel:".$phone['number']."' title='". $label ."'>".$label."</a>";

		$i++;
	}
	return $str;
}
