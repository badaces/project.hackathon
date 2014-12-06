<?php

namespace App\Web\Responder;

use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Response;

class HomeResponder implements ResponderInterface
{
    /**
     * @var Engine
     */
    private $engine;

    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }

    public function execute()
    {
        $engine = $this->engine;

        $content = $engine->make('Home/home')->render();

        return new Response($content, Response::HTTP_OK);
    }
}
