<?php
define("db_ip", "127.0.0.1");
define("db_username", "root");
define("db_password", "");
define("db_name", 'en_stor_restaurant');

$conn = mysqli_connect(db_ip, db_username, db_password, db_name);

if (!$conn) {
    die("ERROR: " . mysqli_connect_error() . ". Error number: " . mysqli_connect_errno());
}
