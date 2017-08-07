<?php
/* https://github.com/SSilence/php-imap-client */
require_once dirname(__DIR__) . '/inc/ImapClient/autoload.php';
require_once dirname(__DIR__) . '/config.php';

use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapClient as Imap;

$encryption = Imap::ENCRYPT_SSL; // TLS OR NULL accepted

// Open connection
try {
    $imap = new Imap($mailbox, $user_imap, $password_imap, $encryption);
} catch (ImapClientException $error) {
    echo $error->getMessage() . PHP_EOL;
    die();
}