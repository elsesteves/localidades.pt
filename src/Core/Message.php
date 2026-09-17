<?php

class Message {

	protected static function mailSend($data) {
		$msg = view('emails/contacts', array(
	      "data" => $data,
	    ), true, 200, false);

	    \Email::send(
			array(
				"subject" => 'Pedido de Contacto',
				"message" => $msg,
			)
		);
	}

	public static function send($data) {
		if (exists($data['msg'])) {
			$msg = \DB::escape_string($data['msg']);
		} else {
			return false;
		}

		if (exists($data['name'])) {
			$name = \DB::escape_string($data['name']);
		} else {
			$name = '';
		}

		if (exists($data['subject'])) {
			$subject = \DB::escape_string($data['subject']);
		} else {
			$subject = '';
		}

		if (exists($data['target_module'])) {
			$moduleName = \DB::escape_string($data['target_module']);

			$sql = "SELECT msg_email FROM _modules WHERE name = '{$moduleName}'";
			$moduleInfo = \DB::results($sql, true);
			if (exists($moduleInfo['msg_email'])) {
				$to_email = \DB::escape_string($moduleInfo['msg_email']);
			}
		} else {
			$moduleName = '';
		}

		if (exists($data['target_id'])) {
			$id = \DB::escape_string($data['target_id']);
		} else {
			$id = 0;
		}

		if (exists($data['from_email'])) {
			$from_email = \DB::escape_string($data['from_email']);
		} else {
			$from_email = '';
		}

		if (exists($data['user_id'])) {
			$user_id = \DB::escape_string($data['user_id']);
		} else {
			$user_id = 0;
		}

		if (!exists($to_email)) {
			$to_email = SITE_CONFIGS['smtp']['to_address'];
		}

		if (exists($data['url'])) {
			$url = \DB::escape_string($data['url']);
		} else {
			$url = '';
		}

		$sql = "INSERT INTO messages SET
			name = '{$name}',
			subject = '{$subject}',
			target_module = '{$moduleName}',
			target_id = {$id},
			from_email = '{$from_email}',
			fk_user = {$user_id},
			to_email = '{$to_email}',
			msg = '{$msg}',
			url = '{$url}'";
		\DB::run($sql);

		self::mailSend($data);

		return true;
	}
}