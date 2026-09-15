<?php

namespace App\Exception\Cart;

class CartAlreadyPaidException extends \RuntimeException
{
    /**
     * Signals an attempt to modify a cart that has already been paid.
     */
    public function __construct()
    {
        // le message ne porte pas l'identifiant du panier : il finirait dans le journal
        parent::__construct('This cart has already been paid and can no longer be modified.');
    }
}
