<?php

namespace App\Exception\Cart;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CartAlreadyPaidException extends HttpException
{
    /**
     * Signals an attempt to modify a cart that has already been paid.
     */
    public function __construct()
    {
        // le message ne porte pas l'identifiant du panier : il finirait dans le journal
        parent::__construct(Response::HTTP_CONFLICT, 'Panier déjà payé');
    }
}
