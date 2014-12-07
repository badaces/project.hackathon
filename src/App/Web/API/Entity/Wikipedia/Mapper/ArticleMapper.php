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
}
