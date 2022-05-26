<?php
define("db_ip", "192.168.1.53");
define("db_username", "root");
define("db_password", "");
define("db_name", '"en_stor"_restaurant');

if (!$conn = mysqli_connect(db_ip, db_username, db_password, db_name)) {
    echo "ERROR: Could not connect to DB";
    echo mysqli_connect_error();
    echo mysqli_connect_errno();
    exit();
}
