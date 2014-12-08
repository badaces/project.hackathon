<?php

namespace App\Web\API\Consumer;

use App\Web\API\Entity\Wikipedia\Article;
use App\Web\API\Entity\Wikipedia\Mapper\ArticleMapper;
use App\Web\API\Exception\DataNotFoundException;
use App\Web\API\Exception\InvalidArgumentException;
use Guzzle\Http\Client;

class Wikipedia extends AbstractConsumer
{
    /**
     * @var string
     */
    private $baseUrl = 'http://en.wikipedia.org/w/api.php';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $defaultQuery = [
        'format' => 'json'
    ];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $name
     * @return Article
     * @throws InvalidArgumentException
     * @throws DataNotFoundException
     */
    public function getArticleByName($name)
    {
        if (!is_string($name) || strlen($name) === 0) {
            throw new InvalidArgumentException('$name must be a string');
        }

        $client = $this->client;

        $query = array_merge($this->defaultQuery, [
            'action' => 'query',
            'continue' => '',
            'prop' => 'extracts',
            'explaintext' => '',
            'titles' => $name
        ]);

        $request = $client->get(
            $this->baseUrl,
            null,
            [
                'query' => $query
            ]
        );

        $response = json_decode($this->sendRequest($request)->getBody(true), true);
        $pages = $response['query']['pages'];
        $articleData = end($pages);

        if (array_key_exists('missing', $articleData)) {
            throw new DataNotFoundException(sprintf(
                'Could not find Wikipedia article named "%s"',
                $name
            ));
        }

        $article = ArticleMapper::fromArray([
            'content' => $articleData['extract'],
            'id' => $articleData['pageid'],
            'summary' => $this->getArticleSummary($articleData['extract']),
            'title' => $articleData['title']
        ]);

        return $article;
    }

    private function getArticleSummary($content)
    {
        $position = mb_strpos($content, '==');
        $summary = mb_substr($content, 0, $position);

        return trim($summary);
    }
}
