<?php

namespace App\Exception\Trip;

class TripNotFoundException extends \RuntimeException
{
    /**
     * Signals a lookup on a trip identifier that matches nothing.
     */
    public function __construct()
    {
        // le message ne porte pas l'identifiant : il finirait dans le journal
        parent::__construct('No trip carries this identifier.');
    }
}
