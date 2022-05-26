<?php
define("db_ip", ""); // database ip address
define("db_username", ""); // username
define("db_password", ""); // password
define("db_name", 'en_stor_restaurant'); // name

$conn = mysqli_connect(db_ip, db_username, db_password, db_name);

if (!$conn) {
    die("ERROR: " . mysqli_connect_error() . ". Error number: " . mysqli_connect_errno());
}
