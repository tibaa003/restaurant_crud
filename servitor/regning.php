<?php
include("../include/config.php");
$query = "SELECT COUNT(*) AS cnt FROM bord";
if ($stmt = mysqli_prepare($conn, $query)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $bord_antall = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Regning</title>
</head>

<body>
    <?php require_once("../include/header.php") ?>
    <form id="regning_form" action="./lag_regning.php" method="POST">
        <div>
            <label for="bordnummer">Skriv inn bordnummer:</label>
            <input type="number" id="bordnummer" name="bordnummer" min=1 max=<?php echo $bord_antall["cnt"]; ?> step="1" required>
        </div>
        <input type="submit" value="Skriv ut kvittering">
    </form>
</body>

</html>