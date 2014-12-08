<?php

namespace App\Web\Responder;

use App\Web\API\Entity\Wikipedia\Article;
use App\Web\API\Entity\Wikipedia\Mapper\ArticleMapper;
use Symfony\Component\HttpFoundation\Response;

class GetWikipediaArticleResponder implements ResponderInterface
{
    /**
     * @var Article
     */
    private $article;

    /**
     * @var bool
     */
    private $hasError;

    public function execute()
    {
        $returnData = [
            'result' => null,
            'error' => null
        ];

        $statusCode = Response::HTTP_OK;

        if (!$this->hasError) {
            $returnData['result'] = ArticleMapper::toArray($this->article);
        } else {
            $statusCode = Response::HTTP_NOT_FOUND;
            $returnData['error'] = [
                'code' => $statusCode,
                'message' => 'Could not find the requested article'
            ];
        }

        return new Response(json_encode($returnData), $statusCode, [
            'Content-Type' => 'application/json;charset=utf-8'
        ]);
    }

    public function setArticle(Article $article)
    {
        $this->article = $article;
    }

    public function setHasError()
    {
        $this->hasError = true;
    }
}
