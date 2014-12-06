<?php

namespace App\Web\Action;

use App\Web\Responder\ResponderInterface;

interface ActionInterface
{
    /**
     * @return ResponderInterface
     */
    public function execute();
}
