<?php
require_once dirname(__FILE__) . '/db.php';

if (!empty($_POST)) {
    $response = [];
    $errors = [];
    
    //Email destination address
    if (filter_var(trim($_POST['destination']), FILTER_VALIDATE_EMAIL) != false) {
        $destination = $_POST['destination'];
    } elseif (strlen($_POST['destination']) == 0) {
        $errors['destination_empty'] = 'Recipient not specified!';
    } else {
        $errors['destination'] = 'Email is not valid!';
    }
    
    // Email subject
    if (strlen($_POST['subject']) == 0) {
        $subject = 'Без темы';
    } else {
        $subject = substr(strip_tags(trim($_POST['subject'])), 0, 70);
        $subject = $conn->real_escape_string($subject);
    }
    
    // Email text
    $text_message = strip_tags($_POST['text_message']);
    $text_message = $conn->real_escape_string($text_message);
    
    $headers = "From: almostGmail <almostGmail@jokerr.asuscomm.com>" . "\r\n";
    
    if (empty($errors)) {
        if (mail("$destination", "$subject", "$text_message", $headers)) {
            $response['status'] = 'ok';
            
            $sql_insert = "INSERT INTO outgoing (destination, subject, departure_date, text_message)
                   VALUES ('$destination', '$subject', NOW(), '$text_message');";
            $conn->query($sql_insert);
            
        } else {
            $response['status'] = 'failed';
            $errors['mail_send'] = 'mail() function returned false :(';
        }
    } else {
        $response['status'] = 'failed';
        $response['errors'] = $errors;
    }
    echo json_encode($response); // return JSON answer
    $conn->close();
} else {
    $conn->close();
    echo 'Silence is golden.';
}