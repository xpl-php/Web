<?php

namespace xpl\Web;

use xpl\Routing\Router;
use xpl\Routing\Matcher\UriStrategy;

class Kernel
{
	/**
	 * @var \xpl\Web\Request
	 */
	protected $request;
	
	/**
	 * @var \xpl\Routing\Router
	 */
	protected $router;
	
	public function __construct(Request $request, Router $router) {
		$this->request = $request;
		$this->router = $router;
	}
	
	/**
	 * Routes the request and returns the matched route.
	 * 
	 * @return \xpl\Routing\RouteInterface Matched route.
	 */
	public function __invoke() {
		
		if (! $this->router->hasStrategy()) {
			$this->router->setStrategy(new UriStrategy($this->request->getMethod(), $this->request->getUri()));
		}
		
		if (! $this->router->__invoke()) {
			return false;
		}
		
		if ($params = $this->router->getMatch()->getParams()) {
			$this->request->setPathParams($params);
		}
		
		return $this->router->getMatch();
	}
	
}
