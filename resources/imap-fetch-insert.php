<?php
require_once dirname(__FILE__) . '/db.php';
require_once dirname(__FILE__) . '/imap-connect.php';


// Select the folder INBOX
$imap->selectFolder('INBOX');

// Fetch all emails in the currently selected folder
$incoming_mails = $imap->getMessages(10);

$sql_insert_inc_msgs = "INSERT INTO incoming (uid, sender, subject, receiving_date, text_message) VALUES ";

$sql_vals = [];
foreach ($incoming_mails as $incoming_mail) {
    if(isset($incoming_mail->header->uid )){
        $from = isset($incoming_mail->header->from) ? $incoming_mail->header->from : '';
        $subject = isset($incoming_mail->header->subject) ? $incoming_mail->header->subject : '';
        $date = isset($incoming_mail->header->date) ? date('Y-m-d H:i:s', strtotime($incoming_mail->header->date)) : '';
        $text = isset($incoming_mail->message->text) ? trim($incoming_mail->message->text) : '';
    
        $sql_vals[] = "('" . $incoming_mail->header->uid . "'";
        $sql_vals[] = "'" . $from  . "'";
        $sql_vals[] = "'" . $subject  . "'";
        $sql_vals[] = "'" . $date . "'";
        $sql_vals[] = "'" . $text. "')";
    }
}
$sql_insert_inc_msgs.= implode(', ', $sql_vals) . ';';

$last_local_uid_array = mysqli_fetch_assoc($conn->query("SELECT uid FROM incoming ORDER BY uid DESC LIMIT 1;"));
$last_server_uid = $incoming_mails[0]->header->uid;

if (!empty($last_local_uid_array)) {
    if ($last_local_uid_array['uid'] != $last_server_uid) {
        $conn->query("TRUNCATE TABLE incoming;");
        $conn->query($sql_insert_inc_msgs);
    }
} else {
    $conn->query($sql_insert_inc_msgs);
}
$conn->close();
