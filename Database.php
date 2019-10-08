<?php

class database
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct( $dsn, $user, $pass)
    {
        $this->pdo = new PDO($dsn, $user, $pass);
    }

    public function armors($idArmor): array
    {
        $query = "SELECT * FROM armor WHERE id=$idArmor";
        $statement = $this->pdo->query($query);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function weapons($idWeapon): array
    {
        $query = "SELECT * FROM weapon WHERE id=$idWeapon";
        $statement = $this->pdo->query($query);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function races($race) :array
    {
        $query = "SELECT * FROM race WHERE name='$race'";
        $statement = $this->pdo->query($query);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

}