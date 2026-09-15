<?php

namespace App\Exception\Cart;

class CartLineNotFoundException extends \RuntimeException
{
    /**
     * Signals a lookup on a cart line identifier that matches nothing in this cart.
     */
    public function __construct()
    {
        // le message ne porte pas l'identifiant : il finirait dans le journal
        parent::__construct('No line carries this identifier in this cart.');
    }
}
