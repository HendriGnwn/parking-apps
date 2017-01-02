<?php

return [
	'class' => 'zyx\phpmailer\Mailer',
	'viewPath' => '@app/mail',
	'useFileTransport' => true,
	'config' => [
		'mailer' => 'smtp',
		'host' => null,
		'port' => '465',
		'smtpsecure' => 'ssl',
		'smtpauth' => true,
		'username' => null,
		'password' => null,
	],
];