<?php

namespace App\Exception\Cart;

class CartNotFoundException extends \RuntimeException
{
    /**
     * Signals a lookup on a cart identifier that matches nothing.
     */
    public function __construct()
    {
        // le message ne porte pas l'identifiant : il finirait dans le journal
        parent::__construct('No cart carries this identifier.');
    }
}
