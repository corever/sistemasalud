<?php

namespace App\Farmacia\Talonarios\Entity;

class DAOTalonariosCreados extends \pan\Kore\Entity
{

    protected $table       = TABLA_TALONARIO_CREADOS;
    protected $primary_key = "tc_id";

    function __construct()
    {
        parent::__construct();
    }
}
