<?php

namespace App\Farmacia\Talonarios\Entity;

class DAODesasignacionTalonario extends \pan\Kore\Entity
{

    protected $table       = TABLA_DESASIGNACION_TALONARIO;
    protected $primary_key = "desasignacion_id";

    function __construct()
    {
        parent::__construct();
    }

}
