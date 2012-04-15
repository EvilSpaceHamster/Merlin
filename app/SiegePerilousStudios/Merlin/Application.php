<?php

namespace SiegePerilousStudios\Merlin;

use Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	Doctrine\Common\ClassLoader,
	Doctrine\Common\Annotations\AnnotationReader,
	Doctrine\ODM\MongoDB\DocumentManager,
	Doctrine\MongoDB\Connection,
	Doctrine\ODM\MongoDB\Configuration,
	Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
;

/**
 * Description of Application
 *
 * @author alisdairrankine
 */
class Application {

	/**
	 *
	 * @var Symfony\Component\HttpFoundation\Request
	 */
	private $request;
	
	/**
	 *
	 * @var Doctrine\ODM\MongoDB\DocumentManager
	 */
	private $database;
	
	/**
	 *
	 * @var Symfony\Component\HttpFoundation\Response
	 */
	public $response;
	
	public $route;
	public $basePath = "/srv/www/contentbymerlin.com/";
	public $baseURL = "//www.contentbymerlin.com/app.php/";
	public $rewritten = false;
	
	public $mime = "text/html";
	
	public $status = 200;
	
	public $appState;
	
	public $staticURL = "//static.contentbymerlin.com";
	
	
	private $plugins = array();

	public function __construct($appState = "production") {
		//whatever
		
		$this->appState = $appState;
		
		$this->generateRequest();
	}
	
	public function registerPlugin($pluginDirectory){
		//todo
	}
	
	public function getHandler($handlerName){
		//todo: make this configgable
		$handlers = array(
			"AdminHandler" => "SiegePerilousStudios\Merlin\Admin\AdminHandler",
			"URLManagementHandler" => "SiegePerilousStudios\Merlin\Admin\URLManagement\URLManagementHandler",
			"RouteAPIHandler" => "SiegePerilousStudios\Merlin\API\RouteAPIHandler"
		);
		
		if (isset($handlers[$handlerName]) && class_exists($handlers[$handlerName]) && is_subclass_of($handlers[$handlerName], "SiegePerilousStudios\Merlin\ManagedRouter\RouteHandler")){
			return new $handlers[$handlerName]($this);
		}
		return false;
	}

	private function generateRequest() {
		$this->request = Request::createFromGlobals();
	}

	/**
	 *
	 * @return Symfony\Component\HttpFoundation\Request 
	 */
	public function getRequest() {
		if (empty($this->request)) {
			$this->generateRequest();
		}

		return $this->request;
	}

	public function redirectToLoginPage() {
		$this->redirect("/login/");
	}

	private function redirect($uri){
		
	}

	public function run() {
		$route = $this->findHandlerForURI($this->getRequest()->getRequestUri());
		$handler = $this->getHandler($route->handlerName);
		if ($handler !== false){
			$this->route = $route;
			$content = $handler->route();
		} else {
			$this->status= 501;
			$content = "Handler not available: ".$route->handlerName;
		}
		$this->response->create($content, $this->status, array(
			"content"
		))
		
	}

	private function findHandlerForURI($uri) {
		$router = new ManagedRouter\Router($this);
		if (!$this->rewritten){
			$router->stripURIOneLevel(true);
		}
		$this->route= $router->getRoute();
		return $this->route;
	}

	public function hasClearance($authorisation) {
		$acl; //get acl instance from authorisation name
		//if user has authorisation in acl
		return true;


		//else;
		return false;
	}

	/**
	 *
	 * @return Doctrine\ODM\MongoDB\DocumentManager
	 */
	public function getDatabase() {

		if (empty($this->database)){
			$config = new Configuration();
			$config->setProxyDir($this->basePath . 'cache');
			$config->setProxyNamespace('Proxies');
			$config->setDefaultDB("merlin");
			$config->setHydratorDir($this->basePath . 'cache');
			$config->setHydratorNamespace('Hydrators');
			
			AnnotationDriver::registerAnnotationClasses();
			$reader = new \Doctrine\Common\Annotations\FileCacheReader(
					new AnnotationReader(),
					$this->basePath . 'cache',
					$debug = true
					);
			
			//add all document paths for all plugins/modules
			$documentPaths = array(
				$this->basePath."app/SiegePerilousStudios/Merlin/ManagedRouter/Model"
			);
			
			
			$config->setMetadataDriverImpl(new AnnotationDriver($reader,$documentPaths));

			$dm = DocumentManager::create(new Connection(), $config);

			$this->database=$dm;
		}
		return $this->database;
	}

}