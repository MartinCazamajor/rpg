<?php

require_once '../connec.php';
require_once '../class/Check.php';
require_once '../class/Database.php';
use Weapon\Check;
use Ressource\database;

$formCheck = new Check($_POST);
$pdo = new Database(DSN, USER, PASS);

$_POST = $formCheck->methodCheck();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nameError = $formCheck->checkName();
    $damageMinError = $formCheck->checkDamageMin();
    $damageMaxError = $formCheck->checkDamageMax();
    $priceError = $formCheck->checkPrice();
    $send = $pdo->addWeapon($formCheck->getValid(),$_POST);
}

$weapons = $pdo->showWeapons();

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Armes sacrées</title>
</head>
<body>
<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">RPGladiator</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Forge des Dieux
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/forge/weapon.php">Armes sacrées</a>
                        <a class="dropdown-item" href="/forge/armor.php">Armures divines</a>
                        <a class="dropdown-item" href="/forge/race.php">Moule racial</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <form action="" method="post">
        <div class="form-group">
            <label for="name"><?= isset($nameError) ? $nameError : "Name"; ?></label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter the name of the weapon" value="<?= isset($nameError) ? null : $_POST['name']; ?>">
        </div>
        <div class="row">
            <div class="form-group col">
                <label for="damageMin"><?= isset($damageMinError) ? $damageMinError : "Minimum damage"; ?></label>
                <input type="number" class="form-control" name="damageMin" id="damageMin" placeholder="Minimum damage" value="<?= isset($damageMinError) ? null : $_POST['damageMin']; ?>">
            </div>
            <div class="form-group col">
                <label for="damageMax"><?= isset($damageMaxError) ? $damageMaxError : "Maximum damage"; ?></label>
                <input type="number" class="form-control" name="damageMax" id="damageMax" placeholder="Maximum damage" value="<?= isset($damageMaxError) ? null : $_POST['damageMax']; ?>">
            </div>
            <div class="form-group col">
                <label for="price"><?= isset($priceError) ? $priceError : "Price"; ?></label>
                <input type="number" class="form-control" name="price" id="price" placeholder="Price of the weapon" value="<?= isset($priceError) ? null : $_POST['price']; ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Create a new weapon</button>
    </form>
    <h4><?= isset($send)?$send:"" ?></h4>

    <div class="row justify-content-around">
        <?php foreach ($weapons as $weapon){ ?>
            <div class="card mt-2 border border-dark rounded" style="width: auto;">
                <div class="card-body align-content-center">
                    <h5 class="card-title"><?= ucfirst($weapon['name']); ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $weapon['price'] . " gold"; ?></h6>
                    <p class="card-text"><?= "Damages: " . $weapon['damage_min'] . " - " . $weapon['damage_max']; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>



</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
