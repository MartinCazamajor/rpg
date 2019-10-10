<?php
namespace Ressource;

use Player\Character;

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
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function races($race) :array
    {
        $query = "SELECT * FROM race WHERE name='$race'";
        $statement = $this->pdo->query($query);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function addCharacter(Character $character): string
    {
        $name = $character->getName();
        $query = "SELECT * FROM `character` WHERE name='$name'";
        $statement = $this->pdo->query($query);
        if ($statement->fetch() === false){
            $query = 'INSERT INTO `character` (name, life, id_weapon, id_armor, gold, xp, strength, agility)
                    VALUES
                    (:name, :life, :id_weapon, :id_armor, :gold, :xp, :strength, :agility)';
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':name', $character->getName(), \PDO::PARAM_STR);
            $statement->bindValue(':life', $character->getLife(), \PDO::PARAM_INT);
            $statement->bindValue(':id_weapon', $character->getIdWeapon(), \PDO::PARAM_INT);
            $statement->bindValue(':id_armor', $character->getIdArmor(), \PDO::PARAM_INT);
            $statement->bindValue(':gold', $character->getGold(), \PDO::PARAM_INT);
            $statement->bindValue(':xp', $character->getXp(), \PDO::PARAM_INT);
            $statement->bindValue(':strength', $character->getStrength(), \PDO::PARAM_INT);
            $statement->bindValue(':agility', $character->getAgility(), \PDO::PARAM_INT);
            $statement->execute();
            return "A new character has been added to the database.";
        }
        return "Please choose a different name, this one is already taken.";

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


}