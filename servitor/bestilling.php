<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Lag bestilling</title>
</head>

<body>
    <div>
        <form action="./bestilling.php" method="POST">
            <div class="form-group">
                <label for="bordnummer">Bordnummer: </label>
                <input type="number" min=0 id="bordnummer" name="bordnummer" required step="1">
            </div>
            <div class="form-group">
                <label for="rettnummer">Rettnummer: </label>
                <input type="number" min=0 id="rettnummer" name="rettnummer" required step="1">
            </div>
            <div class="form-group">
                <label for="rett_antall">Rett antall: </label>
                <input type="number" min=0 id="rett_antall" name="rett_antall" required value="1" step="1">
            </div>
            <div>
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>