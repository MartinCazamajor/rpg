<?php

namespace App\Controller;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Method\Check;
use App\Method\Database;
use App\Method\Character;


class Forge
{
    public function character() : array
    {
        $formCheck = new Check($_POST);
        $pdo = new Database(DSN, USER, PASS);

        $_POST = $formCheck->methodCheck();
        $nameError = $send = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameError = $formCheck->checkName();
            $character = new Character();
            $character->creation($_POST['name'], $_POST['race'], $pdo);
            $send = $pdo->addCharacter($formCheck->getValid(),$character);
        }

        $races = $pdo->showRaces();

        return [
            'view' => 'index.html.twig',
            'parameter' => [
                'nameError' => $nameError,
                'races' => $races,
                'send' => $send
            ]
        ];
    }

    public function weapon() : array
    {
        $formCheck = new Check($_POST);
        $pdo = new Database(DSN, USER, PASS);
        $_POST = $formCheck->methodCheck();
        $nameError = $damageMinError = $damageMaxError = $priceError = $send = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameError = $formCheck->checkName();
            $damageMinError = $formCheck->checkDamageMin();
            $damageMaxError = $formCheck->checkDamageMax();
            $priceError = $formCheck->checkPrice();
            $send = $pdo->addWeapon($formCheck->getValid(), $_POST);
        }

        $weapons = $pdo->showWeapons();

        return [
            'view' => 'weapon.html.twig',
            'parameter' => [
                'nameError' => $nameError,
                'damageMinError' => $damageMinError,
                'damageMaxError' => $damageMaxError,
                'priceError' => $priceError,
                'send' => $send,
                'weapons' => $weapons
            ]
        ];
    }

    public function armor() : array
    {
        $formCheck = new Check($_POST);
        $pdo = new Database(DSN, USER, PASS);

        $_POST = $formCheck->methodCheck();
        $nameError = $reducDamageError = $reducAgilityError = $priceError = $send = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameError = $formCheck->checkName();
            $reducDamageError = $formCheck->checkReducDamage();
            $reducAgilityError = $formCheck->checkReducAgility();
            $priceError = $formCheck->checkPrice();
            $send = $pdo->addArmor($formCheck->getValid(),$_POST);
        }

        $armors = $pdo->showArmors();

        return [
            'view' => 'armor.html.twig',
            'parameter' => [
                'nameError' => $nameError,
                'reducDamageError' => $reducDamageError,
                'reducAgilityError' => $reducAgilityError,
                'priceError' => $priceError,
                'send' => $send,
                'armors' => $armors
            ]
        ];
    }
}


