<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">

    <title>"En stor" Resturant</title>
</head>

<body>
    <?php require_once("./include/header.php") ?>
    <div id="nav">
        <a href="./servitor/bestilling.php">Legge til bestilling</a>
        <a href="./kokk/bestillinger.php">Bestillinger</a>
        <a href="./servitor/regning.php">Regning</a>
    </div>
    <?php if (isset($_GET["msg"])) {
        if ($_GET["msg"] == "bestilling") { ?>
            <h2 class="muted">Bestillingen har blitt lagt til</h2>
        <?php } else if ($_GET["msg"] == "kvitt_finnes_ikke") { ?>
            <h2 class="muted">Dette bordet har ikke noen bestillinger</h2>
        <?php } else if ($_GET["msg"] == "betalt") { ?>
            <h2 class="muted">Betaling fullført</h2>
        <?php } else if ($_GET["msg"] == "ikke_betalt") { ?>
            <h2 class="muted">Noe gikk galt med betalingen</h2>
    <?php }
    } ?>
</body>

</html>