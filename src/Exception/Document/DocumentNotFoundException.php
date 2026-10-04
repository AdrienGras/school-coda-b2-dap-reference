<?php

namespace App\Exception\Document;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DocumentNotFoundException extends HttpException
{
    /**
     * Signals a lookup on a document that matches nothing, or whose file is gone from its storage.
     */
    public function __construct()
    {
        // le message ne porte pas l'identifiant : il finirait dans le journal
        parent::__construct(Response::HTTP_NOT_FOUND, 'Document non trouvé');
    }
}
