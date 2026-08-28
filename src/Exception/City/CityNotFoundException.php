<?php

namespace App\Exception\City;

class CityNotFoundException extends \RuntimeException
{
    /**
     * Signals a lookup on a city identifier that matches nothing.
     */
    public function __construct()
    {
        // le message ne porte pas l'identifiant : il finirait dans le journal
        parent::__construct('No city carries this identifier.');
    }
}
