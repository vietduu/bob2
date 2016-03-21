<?php

namespace Bob\Helper;

use Zend\Mvc\Router\Http\RouteInterface;
use Zend\Stdlib\RequestInterface;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Http\Request as HttpRequest;
use Bob\Model\DataMapper\UrlReferenceMapper;
use Bob\Model\DataObject\UrlReference;
use Alice\Controller\UrlController;

class UrlRoute implements RouteInterface
{
	private $urlMapper;
	private $assembledParams = [];

	public function __construct(UrlReferenceMapper $urlMapper)
	{
		$this->urlMapper = $urlMapper;
	}

	public function match(RequestInterface $request, $pathOffset = 0)
	{
		if (!$request instanceof HttpRequest) {
			return;
		}

		$virtualUrl = substr($request->getUri()->getPath(), $pathOffset);
		if (!isset($virtualUrl[0]) || $virtualUrl[0] !== '/'){
			return;
		}
		if (!$page = $this->urlMapper->findByUrl(substr($virtualUrl, 1))){
			return;
		}
		$this->assembledParams = ['page' => $page];

		return new RouteMatch(
			[
				'page' => $page,
				'controller' => UrlController::class,
				'action' => 'index',
			],
			strlen($virtualUrl)
			);
	}

	public function assemble(array $params = array(), array $options = array())
    {
        if (! isset($params['page'])) {
            throw new \InvalidArgumentException('"page" parameter required to assemble');
        }
        if (! $params['page'] instanceof UrlReference) {
            throw new \InvalidArgumentException(sprintf(
                '"page" parameter must be an instance of ' . UrlReference::class . ', %s given',
                is_object($params['page']) ? get_class($params['page']) : gettype($params['page'])
            ));
        }
        return '/' . $params['page']->url;
    }

    public function getAssembledParams()
    {
        return $this->assembledParams;
    }

    public static function factory($options = array())
    {
        throw new \BadMethodCallException('Unsupported!');
    }
}