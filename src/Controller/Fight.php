<?php

namespace App\Controller;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Model\Check;
use App\Model\Database;
use App\Model\Character;


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

        $attacker = $pdo->getCharacter($_POST['attacker']);
        $defender = $pdo->getCharacter($_POST['defender']);


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

    public function delete($name) : array
    {
        $pdo = new Database(DSN, USER, PASS);
        $characterName = str_replace("%20", " ", $name);
        //if (isset($_POST['delete'])) {
            $pdo->deleteCharacter($characterName);
        //}
        return $this->select();
    }

    public function heal(string $name) : array
    {
        $pdo = new Database(DSN, USER, PASS);
        $characterName = str_replace("%20", " ", $name);
        $character = $pdo->getObjectCharacter($characterName);

        //if (isset($_POST['heal'])) {
            $character->healMax();
            $pdo->changeLife($character);
        //}

        return $this->select();
    }
}