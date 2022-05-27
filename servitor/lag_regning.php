<?php
include("../include/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // SELECT regning, rett, bord og servitor info
    $query = "SELECT bestilling.regning_nr, rett.navn AS rett_navn, rett.pris, servitor.navn AS servitor_navn, bestilling.bord_id, bestilling.antall_retter FROM bestilling INNER JOIN bord ON bestilling.bord_id = bord.bord_id INNER JOIN regning_aktiv ON bestilling.regning_nr = regning_aktiv.regning_nr INNER JOIN rett ON bestilling.rett_id = rett.rett_id INNER JOIN servitor ON bord.servitor_id = servitor.servitor_id WHERE bestilling.bord_id = ? AND regning_aktiv.aktiv = 1";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $bord_id);
        $bord_id = $_POST["bordnummer"];
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $bestillinger = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
    }

    if (!isset($bestillinger[0])) {
        header("Location: ../index.php?msg=kvitt_finnes_ikke");
    }
    $totalpris = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Kvittering for bord <?php echo ""; ?></title>
</head>

<body>
    <?php require_once("../include/header.php") ?>
    <textarea cols="30" rows="10" readonly wrap="off">
    <?php
    echo "Kvittering for bordnummer: " . $bestillinger[0]["bord_id"] . "\n";
    echo "-----------------------------------------------\n";
    echo "Rett - Pris - Antall\n";
    for ($i = 0; $i < count($bestillinger); $i++) {
        echo $bestillinger[$i]["rett_navn"] . " - " . $bestillinger[$i]["pris"] . " kr - " . $bestillinger[$i]["antall_retter"] . "\n";
        $totalpris += $bestillinger[$i]["pris"] * $bestillinger[$i]["antall_retter"];
    }
    echo "Sum - " . $totalpris . " kr\n";
    ?>
-----------------------------------------------
Servitor: <?php echo $bestillinger[0]["servitor_navn"]; ?>
    </textarea>
    <form action="./betaling.php" method="POST">
        <input type="hidden" name="regning_nr" value="<?php echo $bestillinger[0]["regning_nr"] ?>">
        <input type="submit" value="Betaling fullført">
    </form>
</body>

</html>