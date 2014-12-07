<?php

namespace App\Web;

use App\Web\Action\ActionInterface;
use DCP\Di\Container;
use DCP\Di\ContainerAwareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Application implements ContainerAwareInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var UrlMatcherInterface
     */
    private $urlMatcher;

    /**
     * @var Container
     */
    private $container;

    public function __construct(Request $request, UrlMatcherInterface $urlMatcher)
    {
        $this->request = $request;
        $this->urlMatcher = $urlMatcher;
    }

    /**
     * @return Response
     */
    public function run()
    {
        $request = $this->request;
        $urlMatcher = $this->urlMatcher;

        try {
            $route = $urlMatcher->match($request->getPathInfo());
            $actionName = sprintf('App\Web\Action\%sAction', $route['controller']);

            /** @var ActionInterface $action */
            $action = $this->container->get($actionName);
            $responder = $action->execute();

            return $responder->execute();
        } catch(ResourceNotFoundException $e) {
            return new Response(sprintf(':-( Could not find %s', $request->getRequestUri()), Response::HTTP_NOT_FOUND);
        }
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}
