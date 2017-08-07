<?php
require_once dirname(__FILE__) . '/db.php';

if (!empty($_POST['msgToDelOutgoing'])) {
    $response = [];
    
    $ids = [];
    foreach ($_POST['msgToDelOutgoing'] as $value) {
        $ids[] = $value;
    }
    $ids_string = implode(', ', $ids);
    $ids_string = $conn->real_escape_string($ids_string);
    
    $conn->query("DELETE FROM outgoing WHERE id IN ($ids_string);");
    
    $response['status'] = 'ok';
    $response['idsToDel'] = $ids;
    echo json_encode($response); // return JSON answer
    
    $conn->close();
} elseif (!empty($_POST['msgToDelIncoming'])) {
    require_once 'imap-connect.php';
    $response = [];
    
    $uids = [];
    foreach ($_POST['msgToDelIncoming'] as $value) {
        $uids[] = $value;
    }
    $uids_string = implode(', ', $uids);
    $uids_string = $conn->real_escape_string($uids_string);
    
    $conn->query("DELETE FROM incoming WHERE uid IN ($uids_string);");
    
    // Get all of the folders (imap)
    $folders = $imap->getFolders();
    
    $trash = "IMAP/Deleted";
    if (!array_key_exists('IMAP/Deleted', $folders)) {
        $imap->addFolder($trash);
    }
    
    $imap->moveMessages($uids, $trash);
    
    $response['status'] = 'ok';
    $response['uidsToDel'] = $uids;
    echo json_encode($response); // return JSON answer
    
    $conn->close();
} else {
    echo 'Silence is golden.';
    $conn->close();
}