<?php
namespace Player;

use Ressource\Database;

class Character
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $race;
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
     * @var string
     */
    private $weapon;
    /**
     * @var string
     */
    private $armor;
    /**
     * @var int
     */
    private $idWeapon;
    /**
     * @var int
     */
    private $idArmor;
    /**
     * @var Database
     */
    private $pdo;

    public function __construct($name, $race, Database $pdo) //faire un menu déroulant pour le choix de la race et éviter les fautes d'entrée
    {
        $this->name = $name;
        $this->pdo = $pdo;
        //récupère les informations liées à la race du personnage

        $races = $pdo->races($race);

        $this->race = $races['name'];
        $this->life = $races['life'];
        $this->strength = $races['strength'];
        $this->agility = $races['agility'];
        $this->idWeapon = $races['id_weapon'];
        $this->idArmor = $races['id_armor'];

        //les deux query suivantes servent à équiper l'arme et l'armure de la race de départ du personnage
        $this->weapon = $pdo->weapons($this->idWeapon)['name'];
        $this->armor = $pdo->armors($this->idArmor)['name'];

    }

    public function showCharacter(): string
    {
        if ($this->life > 0) {
            return "$this->name est un $this->race avec $this->life points de vie, $this->strength points de force et $this->agility points d'agilité.<br>Il est équipé d'un(e) $this->weapon et porte un(e) $this->armor.<br>";
        }
        return "$this->name est décédé...";
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
        return $this->weapon;
    }
    /**
     * @return string
     */
    public function getArmor(): string
    {
        return $this->armor;
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
        return $this->race;
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


