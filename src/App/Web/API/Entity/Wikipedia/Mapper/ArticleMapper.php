<?php

namespace App\Web\API\Entity\Wikipedia\Mapper;

use App\Web\API\Entity\Wikipedia\Article;

class ArticleMapper
{
    /**
     * @param array $data
     * @return Article
     */
    public static function fromArray($data)
    {
        return new Article(
            $data['content'],
            (int)$data['id'],
            $data['summary'],
            $data['title']
        );
    }

    /**
     * @param Article $article
     * @return array
     */
    public static function toArray(Article $article)
    {
        return [
            'content' => $article->getContent(),
            'id' => $article->getId(),
            'summary' => $article->getSummary(),
            'title' => $article->getTitle()
        ];
    }
}
