<?php
namespace App\Method;

use App\Method;

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

    public function creation($name, $race, Database $pdo): void //faire un menu déroulant pour le choix de la race et éviter les fautes d'entrée
    {
        $this->name = $name;
        $this->pdo = $pdo;
        //récupère les informations liées à la race du personnage
        $races = $pdo->selectRace($race);
        $this->idRace = $races['id'];
        $this->life = $races['life'];
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
        $dodge = rand(1, 10);
        if ($ennemy->getAgility() >= $dodge) {
            return "$this->name essaye de frapper " . $ennemy->getName() . " mais ce dernier esquive ! ( jet de $dodge pour " . $ennemy->getAgility() . " d'agilité)";
        } else {
            $rand = rand($this->pdo->weapons($this->idWeapon)['damage_min'], $this->pdo->weapons($this->idWeapon)['damage_max']);
            $armor = $this->pdo->armors($ennemy->getIdArmor())['reduc_damage'];
            $damage = $this->strength + $rand - $armor;
            $lifeEnnemy = $ennemy->getLife();
            $ennemy->setLife($lifeEnnemy-$damage);

            return "$this->name inflige $damage dégâts à "
                . $ennemy->getName()
                ." : $this->strength de sa force + $rand de son arme ($this->weapon) - $armor de l'armure adverse (" . $ennemy->getArmor()
                ."). <br> Il ne lui reste plus que "
                .$ennemy->getLife()
                ." points de vie.";
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
        return $this->pdo->weapons($this->idWeapon)['name'];
    }
    /**
     * @return string
     */
    public function getArmor(): string
    {
        return $this->pdo->armors($this->idArmor)['name'];
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
        return $this->pdo->selectRace($this->idRace)['name'];
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
        $this->life = $life;
    }

}


