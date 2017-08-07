<?php
require_once dirname(__DIR__) . '/config.php';

// Create connection
$conn = new mysqli($servername, $user_db, $password_db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8 COLLATE utf8_general_ci;");
$conn = new mysqli($servername, $user_db, $password_db);
$conn->select_db("$dbname");

$conn->query("SET NAMES 'utf8'");

$table_incoming = "CREATE TABLE IF NOT EXISTS incoming (
    id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
    uid INT NOT NULL,
    sender VARCHAR(80) NOT NULL,
    subject TEXT NOT NULL,
    receiving_date DATETIME NOT NULL,
    text_message LONGTEXT,
    PRIMARY KEY  (id)
  )";

$table_outgoing = "CREATE TABLE IF NOT EXISTS outgoing (
    id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
    destination VARCHAR(80) NOT NULL,
    subject VARCHAR(30) NOT NULL,
    departure_date DATETIME NOT NULL,
    text_message LONGTEXT NOT NULL,
    PRIMARY KEY  (id)
  )";

$conn->query($table_incoming);
$conn->query($table_outgoing);