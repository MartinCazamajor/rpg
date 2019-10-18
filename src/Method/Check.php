<?php

namespace App\Method;


class Check
{
    /**
     * @var ?string
     */
    private $nameError;
    /**
     * @var ?string
     */
    private $damageMinError;
    /**
     * @var ?string
     */
    private $damageMaxError;
    /**
     * @var ?string
     */
    private $priceError;
    /**
     * @var ?string
     */
    private $reducDamageError;
    /**
     * @var ?string
     */
    private $reducAgilityError;
    /**
     * @var bool
     */
    private $valid = true;
    /**
     * @var array
     */
    private $post;

    public function __construct(array $post)
    {
        $this->post = $post;
    }

    public function methodCheck(): ?array
    {
        $post = null;
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->post=[
                "name" => null,
                "damageMin" => null,
                "damageMax" => null,
                "price" => null,
                "reducDamage" => null,
                "reducAgility" => null,
            ];
        }
        return $this->post;
    }

    public function checkName(): ?string
    {
        if (!isset($this->post['name']) || empty($this->post['name'])) {
            $this->nameError = "You should put a name";
            $this->valid = false;
        } elseif (!preg_match("/^[a-zA-Zéèùôûêîâç' -]*$/", $this->post['name']) || strlen($this->post['name']) > 100) {
            $this->nameError = "Please use a valid name and max 100 characters";
            $this->valid = false;
        }
        return $this->nameError;
    }

    public function checkDamageMin(): ?string
    {
        if (!isset($this->post['damageMin']) || empty($this->post['damageMin'])) {
            $this->damageMinError = "*Choose a minimum for the damages*";
            $this->valid = false;
        } elseif (!is_numeric($this->post['damageMin'])){
            $this->damageMinError = "*Enter a number*";
            $this->valid = false;
        } elseif ($this->post['damageMin'] > $this->post['damageMax']) {
            $this->damageMaxError = "*The minimum is too big*";
            $this->valid = false;
        }
        return $this->damageMinError;
    }

    public function checkReducDamage(): ?string
    {
        if (!isset($this->post['reducDamage']) || empty($this->post['reducDamage'])) {
            $this->reducDamageError = "*Choose a damage reduction*";
            $this->valid = false;
        } elseif (!is_numeric($this->post['reducDamage']) || $this->post['reducDamage'] < 0 ){
            $this->reducDamageError = "*Enter a positive number*";
            $this->valid = false;
        }
        return $this->reducDamageError;
    }

    public function checkReducAgility(): ?string
    {
        if (!isset($this->post['reducAgility']) || empty($this->post['reducAgility'])) {
            $this->reducAgilityError = "*Choose an agility reduction*";
            $this->valid = false;
        } elseif (!is_numeric($this->post['reducAgility']) || $this->post['reducAgility'] < 0 ){
            $this->reducAgilityError = "*Enter a positive number*";
            $this->valid = false;
        }
        return $this->reducAgilityError;
    }

    public function checkDamageMax(): ?string
    {
        if (!isset($this->post['damageMax']) || empty($this->post['damageMax'])) {
            $this->damageMaxError = "*Choose a maximum for the damages*";
            $this->valid = false;
        } elseif (!is_numeric($this->post['damageMax'])){
            $this->damageMinError = "*Enter a number*";
            $this->valid = false;
        } elseif ($this->post['damageMin'] > $this->post['damageMax']) {
            $this->damageMaxError = "*The maximum is too little*";
            $this->valid = false;
        }
        return $this->damageMaxError;
    }

    public function checkPrice(): ?string
    {
        if (!isset($this->post['price']) || empty($this->post['price'])) {
            $this->priceError = "*Choose a price*";
            $this->valid = false;
        }
        return $this->priceError;
    }

    public function getValid(): bool
    {
        return $this->valid;
    }



}
