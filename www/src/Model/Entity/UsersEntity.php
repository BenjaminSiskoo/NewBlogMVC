<?php
namespace App\Model\Entity;

use Core\Model\Entity;

class UsersEntity extends Entity
{

    private $id;

    private $lastname;

    private $firstname;

    private $address;

    private $zipCode;

    private $city;

    private $country;

    private $phone;

    private $mail;

    private $password;

    private $token;

    private $createdAt;

    private $verify;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function getpassword(): string
    {
        return $this->password;
    }

    public function setpassword(string $password): void
    {
        $this->password=$password;
    }

    public function gettoken(): string
    {
        return $this->token;
    }

    public function getcreatedAt(): datetime
    {
        return $this->createdAt;
    }

    public function getVerify(): int
    {
        return $this->verify;
    }
}