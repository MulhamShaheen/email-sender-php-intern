<?php
$db_options['type']       = 'mdb2';
// the others are the options for the used container
// here are some for db
//$db_options['dsn']        = 'mysql://user:password@host/database';

$db_options['dsn']        = 'mysql://'.$_ENV['DB_USER'].':'.$_ENV['DB_PASSWORD'].'@'.$_ENV['DB_HOST'].'/'.$_ENV['DB_NAME'];
$db_options['mail_table'] = 'mail_queue';

// here are the options for sending the messages themselves
// these are the options needed for the Mail-Class, especially used for Mail::factory()
$mail_options['driver']    = 'smtp';
//$mail_options['host']      = $_ENV['MAIL_HOST'];
//$mail_options['port']      = $_ENV['MAIL_PORT'];
//$mail_options['localhost'] = $_ENV['MAIL_LOCALHOST'];
$mail_options['auth']      = false;
$mail_options['username']  = '';
$mail_options['password']  = '';
$mail_options['host']      = 'your_server_smtp.com';
$mail_options['port']      = 25;
$mail_options['localhost'] = 'localhost'; //optional Mail_smtp parameter
$mail_options['auth']      = false;
//$mail_options['username']  = '';
//$mail_options['password']  = '';

?>
