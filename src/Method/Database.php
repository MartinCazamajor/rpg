<?php
namespace App\Method;

use App\Method;

class database
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct( $dsn, $user, $pass)
    {
        $this->pdo = new \PDO($dsn, $user, $pass);
    }

    public function armors($idArmor): array
    {
        $query = "SELECT * FROM armor WHERE id=$idArmor";
        $statement = $this->pdo->query($query);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function weapons($idWeapon): array
    {
        $query = "SELECT * FROM weapon WHERE id=$idWeapon";
        $statement = $this->pdo->query($query);
        $return = $statement->fetch(\PDO::FETCH_ASSOC);
        return $return;
    }

    public function selectRace($race) :array
    {
        $query = "SELECT * FROM race WHERE name='$race'";
        $statement = $this->pdo->query($query);
        $races = $statement->fetch(\PDO::FETCH_ASSOC);
        return $races;
    }

    public function addCharacter(bool $valid,Character $character): ?string
    {
        if ($valid) {
            $name = $character->getName();
            $query = "SELECT * FROM `character` WHERE name='$name'";
            $statement = $this->pdo->query($query);
            if ($statement->fetch() === false) {
                $query = 'INSERT INTO `character` (name, life, idWeapon, idArmor, gold, xp, strength, agility, idRace)
                    VALUES
                    (:name, :life, :idWeapon, :idArmor, :gold, :xp, :strength, :agility, :idRace)';
                $statement = $this->pdo->prepare($query);
                $statement->bindValue(':name', $character->getName(), \PDO::PARAM_STR);
                $statement->bindValue(':life', $character->getLife(), \PDO::PARAM_INT);
                $statement->bindValue(':idWeapon', $character->getIdWeapon(), \PDO::PARAM_INT);
                $statement->bindValue(':idArmor', $character->getIdArmor(), \PDO::PARAM_INT);
                $statement->bindValue(':gold', $character->getGold(), \PDO::PARAM_INT);
                $statement->bindValue(':xp', $character->getXp(), \PDO::PARAM_INT);
                $statement->bindValue(':strength', $character->getStrength(), \PDO::PARAM_INT);
                $statement->bindValue(':agility', $character->getAgility(), \PDO::PARAM_INT);
                $statement->bindValue(':idRace', $character->getIdRace(), \PDO::PARAM_INT);
                $statement->execute();
                return "A new character has been added to the database.";
            }
            return "Please choose a different name, this one is already taken.";
        }
        return null;
    }

    public function addWeapon(bool $valid, array $post): ?string
    {
        if ($valid) {
            $name = $post['name'];
            $query = "SELECT * FROM weapon WHERE name ='$name'";
            $statement = $this->pdo->query($query);
            if ($statement->fetch() === false) {
                $query = 'INSERT INTO weapon (name, damage_min, damage_max, price) VALUES (:name, :damage_min, :damage_max, :price)';
                $statement = $this->pdo->prepare($query);
                $statement->bindValue(':name', $post['name'], \PDO::PARAM_STR);
                $statement->bindValue(':damage_min', $post['damageMin'], \PDO::PARAM_INT);
                $statement->bindValue(':damage_max', $post['damageMax'], \PDO::PARAM_INT);
                $statement->bindValue(':price', $post['price'], \PDO::PARAM_INT);
                $statement->execute();
                return "A new weapon has been added to the data base.";
            }
            return "Please choose a different name, this one is already taken.";
        }
        return null;
    }

    public function addArmor(bool $valid, array $post): ?string
    {
        if ($valid) {
            $name = $post['name'];
            $query = "SELECT * FROM armor WHERE name ='$name'";
            $statement = $this->pdo->query($query);
            if ($statement->fetch() === false) {
                $query = 'INSERT INTO armor (name, reduc_damage, reduc_agility, price) VALUES (:name, :reduc_damage, :reduc_agility, :price)';
                $statement = $this->pdo->prepare($query);
                $statement->bindValue(':name', $post['name'], \PDO::PARAM_STR);
                $statement->bindValue(':reduc_damage', $post['reducDamage'], \PDO::PARAM_INT);
                $statement->bindValue(':reduc_agility', $post['reducAgility'], \PDO::PARAM_INT);
                $statement->bindValue(':price', $post['price'], \PDO::PARAM_INT);
                $statement->execute();
                return "A new armor has been added to the data base.";
            }
            return "Please choose a different name, this one is already taken.";
        }
        return null;
    }

    public function showArmors(): array
    {
        $statement = $this->pdo->query("SELECT * FROM armor");
        $armors = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $armors;
    }

    public function showWeapons(): array
    {
        $statement = $this->pdo->query("SELECT * FROM weapon");
        $weapons = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $weapons;
    }

    public function showRaces(): array
    {
        $statement = $this->pdo->query("SELECT * FROM race");
        $races = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $races;
    }

    public function showCharacters(): array
    {
        $query = "SELECT
       character.name as name, 
       race.name as race,
       character.life as currentLife,
       race.life as maxLife,
       character.strength as strength,
       character.agility as agility,
       weapon.name as weapon,
       armor.name as armor
        FROM `character` 
            INNER JOIN race ON character.idRace = race.id
            INNER JOIN weapon on character.idWeapon = weapon.id
            INNER JOIN armor on character.idArmor = armor.id";
        $statement = $this->pdo->query($query);
        $characters = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $characters;
    }

    public function getObjectCharacter($name): Character
    {
        $statement = $this->pdo->query("SELECT * FROM `character` WHERE name='$name'");
        $statement->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'App\Method\Character');
        $character = $statement->fetch();

        return $character;
    }

    public function changeLife(Character $character)
    {
        $name = $character->getName();
        $life = $character->getLife();
        $query = "UPDATE `character` SET life = $life WHERE name='$name'";
        $this->pdo->query($query);
    }

}