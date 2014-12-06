<?php

namespace App\Web\Action;

use App\Web\Responder\HomeResponder;

class HomeAction implements ActionInterface
{
    /**
     * @var HomeResponder
     */
    private $responder;

    public function __construct(HomeResponder $responder)
    {
        $this->responder = $responder;
    }

    public function execute()
    {
        return $this->responder;
    }
}
