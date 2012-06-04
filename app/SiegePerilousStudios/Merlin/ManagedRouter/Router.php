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

	public function __construct(\SiegePerilousStudios\Merlin\Application &$app) {
		$this->app = $app;
		$this->uri = $this->app->getRequest()->getRequestUri();
	}

	public function getRoute() {

		$dm = $this->app->getDatabase();
		$route = $dm->createQueryBuilder("SiegePerilousStudios\\Merlin\\ManagedRouter\\Model\\Route")
				->field("uri")->equals($this->uri)
				->getQuery()
				->getSingleResult();
		
		if ($route !== null) {
			return $route;
		}
		if ($this->uri=="//"){
			return false;
		}
		
		
		$this->stripURIOneLevel();
		return $this->getRoute();
	}
	
	public function stripURIOneLevel($reverse = false){
		
		$strippedURI = explode("/",trim($this->uri,"/"));
		if ($reverse){
			$strippedURI = array_reverse($strippedURI);
		}
		array_pop($strippedURI);
		if ($reverse){
			$strippedURI = array_reverse($strippedURI);
		}
		$this->uri= "/" . implode("/",$strippedURI) . "/";
		
		
	}
	
	
	
	

}
