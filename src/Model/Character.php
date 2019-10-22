<?php
namespace App\Model;

use App\Model;

class Character
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $life;
    /**
     * @var int
     */
    private $gold = 0;
    /**
     * @var int
     */
    private $xp = 0;
    /**
     * @var int
     */
    private $strength;
    /**
     * @var int
     */
    private $agility;
    /**
     * @var int
     */
    private $idWeapon;
    /**
     * @var int
     */
    private $idArmor;
    /**
     * @var int
     */
    private $idRace;
    /**
     * @var Database
     */
    private $pdo;

    /**
     * @var int
     */
    private $lifeMax;

    public function creation($name, $race, Database $pdo): void
    {
        $this->name = $name;
        $this->pdo = $pdo;
        //récupère les informations liées à la race du personnage
        $races = $pdo->selectRace($race);
        $this->idRace = $races['id'];
        $this->life = $this->lifeMax = $races['life'];
        $this->strength = $races['strength'];
        $this->agility = $races['agility'];
        $this->idWeapon = $races['id_weapon'];
        $this->idArmor = $races['id_armor'];

        //les deux query suivantes servent à équiper l'arme et l'armure de la race de départ du personnage
        $this->idWeapon = $pdo->weapons($this->idWeapon)['id'];
        $this->idArmor = $pdo->armors($this->idArmor)['id'];
    }

    public function attack(Character $ennemy): string
    {
        $pdo = new Database(DSN, USER, PASS);
        $dodge = rand(1, 10);
        if ($ennemy->getAgility() >= $dodge) {
            return "$this->name essaye de frapper ".
                $ennemy->getName().
                " mais rate ! ( jet de $dodge pour ".
                $ennemy->getAgility().
                " d'agilité)";
        } else {
            $rand = rand($pdo->weapons($this->idWeapon)['damage_min'], $pdo->weapons($this->idWeapon)['damage_max']);
            $armor = $pdo->armors($ennemy->getIdArmor())['reduc_damage'];
            $damage = $this->strength + $rand - $armor;
            $lifeEnnemy = $ennemy->getLife();
            $ennemy->setLife($lifeEnnemy-$damage);

            return "$this->name inflige $damage dégâts à ".
                $ennemy->getName().
                " : $this->strength de sa force + $rand de son arme - $armor de l'armure adverse (".
                $ennemy->getArmor().
                "). Il ne lui reste plus que ".
                $ennemy->getLife().
                " points de vie.";
        }
    }

    /**
     * @return int
     */
    public function getLife(): int
    {
        return $this->life;
    }
    /**
     * @return int
     */
    public function getAgility(): int
    {
        return $this->agility;
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @return string
     */
    public function getWeapon(): string
    {
        $pdo = new Database(DSN, USER, PASS);
        return $pdo->weapons($this->idWeapon)['name'];
    }
    /**
     * @return string
     */
    public function getArmor(): string
    {
        $pdo = new Database(DSN, USER, PASS);
        return $pdo->armors($this->idArmor)['name'];
    }
    /**
     * @return int
     */
    public function getIdArmor(): int
    {
        return $this->idArmor;
    }
    /**
     * @return int
     */
    public function getIdWeapon(): int
    {
        return $this->idWeapon;
    }
    /**
     * @return int
     */
    public function getGold(): int
    {
        return $this->gold;
    }
    /**
     * @return string
     */
    public function getRace(): string
    {
        $pdo = new Database(DSN, USER, PASS);
        return $pdo->selectRace($this->idRace)['name'];
    }
    /**
     * @return int
     */
    public function getIdRace(): int
    {
        return $this->idRace;
    }
    /**
     * @return int
     */
    public function getXp(): int
    {
        return $this->xp;
    }
    /**
     * @return int
     */
    public function getStrength(): int
    {
        return $this->strength;
    }

    /**
     * @param int $life
     */
    public function setLife(int $life): void
    {
        if ($life < 0) {
            $this->life = 0;
        } else {
            $this->life = $life;
        }
    }

    /**
     * @return int
     */
    public function getlifeMax(): int
    {
        return $this->lifeMax;
    }

    public function healMax(): void
    {
        $this->setLife($this->lifeMax);
    }
}
