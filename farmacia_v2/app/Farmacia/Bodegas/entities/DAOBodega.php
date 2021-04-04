<?php

namespace App\Farmacia\Bodegas\Entity;

class DAOBodega extends \pan\Kore\Entity
{

    protected $table       = TABLA_BODEGA;
    protected $primary_key = "bodega_id";

    function __construct()
    {
        parent::__construct();
    }
}
