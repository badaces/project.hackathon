<?php

namespace App\Web\Responder;

use Symfony\Component\HttpFoundation\Response;

class HomeResponder implements ResponderInterface
{
    public function execute()
    {
        return new Response('Huzzah!!', Response::HTTP_OK);
    }
}
