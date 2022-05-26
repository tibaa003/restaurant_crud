<?php
include("../include/config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = "UPDATE regning_aktiv SET aktiv = ? WHERE regning_nr = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "ii", $ikke_aktiv, $regning_nr);
        $regning_nr = $_POST["regning_nr"];
        $ikke_aktiv = 0;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: ../index.php?msg=betalt");
    }
} else {
    header("Location: ../index.php?msg=ikke_betalt");
}
