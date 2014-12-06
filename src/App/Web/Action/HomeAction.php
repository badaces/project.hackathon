<?php

namespace App\Web\Action;

use App\Web\Responder\HomeResponder;

class HomeAction implements ActionInterface
{
    public function execute()
    {
        return new HomeResponder();
    }
}
