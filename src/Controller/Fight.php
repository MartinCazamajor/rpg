<?php

namespace App\Controller;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Method\Check;
use App\Method\Database;
use App\Method\Character;


class Fight
{
    public function select(): array
    {
        $pdo = new Database(DSN, USER, PASS);
        $characters = $pdo->showCharacters();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['attacker']) && !empty($_POST['defender'])) {
            return $this->versus();
        }
        return [
            'view' => 'fight.html.twig',
            'parameter' => ['characters' => $characters]
        ];
    }

    public function versus(): array
    {
        $pdo = new Database(DSN, USER, PASS);
        $attackerObject = $pdo->getObjectCharacter($_POST['attacker']);
        $defenderObject = $pdo->getObjectCharacter($_POST['defender']);

        $result = $attackerObject->attack($defenderObject);

        $pdo->changeLife($defenderObject);

        $characters = $pdo->showCharacters();

        foreach ($characters as $character) {
            if (in_array($_POST['attacker'], $character)) {
                $attacker = $character;
            } elseif (in_array($_POST['defender'], $character)) {
                $defender = $character;
            }
        }



        return [
            'view' => 'versus.html.twig',
            'parameter' => [
                'attackerObject' => $attackerObject,
                'defenderObject' => $defenderObject,
                'attacker' => $attacker,
                'defender' => $defender,
                'result' => $result]
        ];
    }
}