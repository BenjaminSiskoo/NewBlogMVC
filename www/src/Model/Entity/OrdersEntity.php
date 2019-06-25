<?php
namespace App\Model\Entity;

use Core\Model\Entity;

class BeerEntity extends Entity
{

    private $id;

    private $id_user;

    private $ids_product;

    private $priceTTC;

    public function getId(): int
    {
        return $this->id;
    }

    public function getId_user(): int
    {
        return $this->id_user;
    }

    public function getIds_product(): string
    {
        return $this->ids_product;
    }

    public function getPriceTTC(): float
    {
        return $this->priceTTC;
    }
}