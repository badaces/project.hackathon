<?php

namespace App\Web\Action;

use App\Web\API\Consumer\Wikipedia;
use App\Web\API\Exception as APIException;
use App\Web\Responder\GetWikipediaArticleResponder;
use Symfony\Component\HttpFoundation\Request;

class GetWikipediaArticleAction implements ActionInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var GetWikipediaArticleResponder
     */
    private $responder;

    /**
     * @var Wikipedia
     */
    private $wikipedia;

    public function __construct(Request $request, GetWikipediaArticleResponder $responder, Wikipedia $wikipedia)
    {
        $this->request = $request;
        $this->responder = $responder;
        $this->wikipedia = $wikipedia;
    }

    public function execute()
    {
        $request = $this->request;
        $responder = $this->responder;
        $wikipedia = $this->wikipedia;

        $articleName = $request->query->get('title');

        $article = null;
        try {
            $article = $wikipedia->getArticleByName($articleName);
        } catch (APIException $e) {
            $responder->setHasError();
            return $responder;
        }

        $responder->setArticle($article);

        return $responder;
    }
}
