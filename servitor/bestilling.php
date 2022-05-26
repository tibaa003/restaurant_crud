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

$query = "SELECT COUNT(*) AS cnt FROM rett";
if ($stmt = mysqli_prepare($conn, $query)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rett_antall = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
}
date_default_timezone_set("Europe/Oslo");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // select nyeste regning fra samme bord
    $query = "SELECT * FROM regning_aktiv INNER JOIN bestilling ON regning_aktiv.regning_nr = bestilling.regning_nr WHERE bestilling.bord_id = ? ORDER BY regning_aktiv.regning_nr DESC";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $bord_id);
        $bord_id = $_POST["bordnummer"];
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        // hvis queryen ikke får noe resultat (første bestilling for dagen for dette bordet) sett at den ikke er aktiv (lag ny regning)
        if (!$er_aktiv = mysqli_fetch_assoc($result)) {
            $er_aktiv["aktiv"] = 0;
        }
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
    }
    // hvis siste regning ikke er aktiv lenger lag en ny
    if (!$er_aktiv["aktiv"]) {
        $query = "INSERT INTO regning_aktiv (aktiv) VALUES (?)";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $aktiv);
            $aktiv = 1;
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        // hent nyeste regning (den vi skal bruke for denne bestillingen)
        $query = "SELECT regning_nr FROM regning_aktiv ORDER BY regning_aktiv.regning_nr DESC";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $er_aktiv = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
            mysqli_stmt_close($stmt);
        }
    }

    $regning_nr = $er_aktiv["regning_nr"];

    $query = "INSERT INTO bestilling (bord_id, rett_id, antall_retter, bestillings_tidspunkt, regning_nr) VALUES (?,?,?,?,?)";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "iiisi", $bord_id, $rett_id, $antall_retter, $datetime, $regning_nr);

        $bord_id = $_POST["bordnummer"];
        $rett_id = $_POST["rettnummer"];
        $antall_retter = $_POST["rett_antall"];
        $datetime = date("d-m-y H:i:s");

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: ../index.php?msg=bestilling");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">

    <title>Legg til bestilling</title>
</head>

<body>
    <?php require_once("../include/header.php"); ?>

    <form id="bestilling_form" action="./bestilling.php" method="POST">
        <div>
            <label for="bordnummer">Bordnummer: </label>
            <input type="number" min=1 max=<?php echo $bord_antall["cnt"]; ?> id="bordnummer" name="bordnummer" required step="1">
        </div>
        <div>
            <label for="rettnummer">Rettnummer: </label>
            <input type="number" min=1 max=<?php echo $rett_antall["cnt"]; ?> id="rettnummer" name="rettnummer" required step="1">
        </div>
        <div>
            <label for="rett_antall">Rett antall: </label>
            <input type="number" min=1 id="rett_antall" name="rett_antall" required value="1" step="1">
        </div>
        <div>
            <input type="submit" value="Submit">
        </div>
    </form>

</body>

</html>