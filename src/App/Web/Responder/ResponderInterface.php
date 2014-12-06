<?php

namespace App\Web\Responder;

use Symfony\Component\HttpFoundation\Response;

interface ResponderInterface
{
    /**
     * @return Response
     */
    public function execute();
}
