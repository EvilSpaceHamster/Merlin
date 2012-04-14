<?php

namespace SiegePerilousStudios\Merlin\ManagedRouter;
/**
 * Description of Router
 *
 * @author alisdairrankine
 */
class Router {
	
	private $uri;
	
	/**
	 *
	 * @var \SiegePerilousStudios\Merlin\Application
	 */
	private $app;
	
	public function __construct(\SiegePerilousStudios\Merlin\Application &$app){
		$this->app = $app;
		$this->uri = $this->app->getRequest()->getRequestUri();
		
	}
	
	
	
	public function getRoute(){
		//find route;
		$route = new Route();
		
		if ($this->app->hasClearance($route->authorisation)){
			return $route;
		}
	}
	
}
