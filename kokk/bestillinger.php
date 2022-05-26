<?php
include("../include/config.php");

date_default_timezone_set("Europe/Oslo");




// select rett navn, antall av retten og ansvarlig servitør, sorter med dato - eldste først
$query = "SELECT bestilling.bestilling_id, rett.navn AS rett_navn, servitor.navn AS servitor_navn, bestilling.antall_retter FROM ((( bestilling INNER JOIN bord ON bestilling.bord_id = bord.bord_id) INNER JOIN servitor ON bord.servitor_id = servitor.servitor_id) INNER JOIN rett ON bestilling.rett_id = rett.rett_id) WHERE bestilling.serverings_tidspunkt IS NULL ORDER BY bestillings_tidspunkt";
if ($stmt = mysqli_prepare($conn, $query)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $bestillinger = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = "UPDATE bestilling SET serverings_tidspunkt = ? WHERE bestilling_id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "si", $datetime, $id);
        $datetime = date("d-m-y H:i:s");
        $id = $_POST["bestilling_id"];
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    // refresh page
    header("Refresh:0");
}
// refresh page hver 5 sekund for å holde det oppdatert
header("Refresh:5")
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Bestillinger</title>
</head>

<body>
    <?php require_once("../include/header.php"); ?>
    <div id="bestillinger">
        <?php
        for ($i = 0; $i < count($bestillinger); $i++) { ?>
            <div class="bestilling">
                <div class="rett_bestilling">
                    <p><?php echo $bestillinger[$i]["rett_navn"] ?></p>
                    <p><?php echo $bestillinger[$i]["antall_retter"] ?></p>
                </div>
                <p><?php echo $bestillinger[$i]["servitor_navn"] ?></p>
                <form action="./bestillinger.php" method="POST">
                    <input type="hidden" name="bestilling_id" value="<?php echo $bestillinger[$i]["bestilling_id"] ?>">
                    <input type="submit" value="Fullfør">
                </form>
            </div>
        <?php } ?>
    </div>
</body>

</html>