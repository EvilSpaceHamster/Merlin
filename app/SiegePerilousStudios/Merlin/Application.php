<?php

namespace SiegePerilousStudios\Merlin;

use Symfony\Component\HttpFoundation\Request,
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
	private $database;
	public $response;
	
	public static $basePath = "/srv/www/contentbymerlin.com/";
	public static $baseURL = "www.contentbymerlin.com/app.php/";
	public static $rewritten = false;
	
	private $plugins = array();

	public function __construct() {
		//whatever

		$this->generateRequest();
	}
	
	public function registerPlugin($pluginDirectory){
		//todo
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

	private function redirect($uri);

	public function run() {
		echo "HELLO" . $this->request->getRequestUri();
		exit;
		/*
		  $url = $this->request->getUri();
		  $handlerName = $this->findHandlerForURI($url);
		  if ($handlerName!==false){
		  $handler = new $handlerName($this);
		  }
		 */
	}

	private function findHandlerForURI($uri) {
		$handler; //= getHandler...
		if (!empty($handler)) {
			return $handler;
		}
		$subUri; //= uri down a level
		if ($subUri === false) {
			return false;
		}

		return findHandlerForUri($subUri);
	}

	public function hasClearance($authorisation) {
		$acl; //get acl instance from authorisation name
		//if user has authorisation in acl
		return true;


		//else;
		return false;
	}

	public function getDatabase() {

		if (empty($this->database)){
			$config = new Configuration();
			$config->setProxyDir(self::$basePath . 'cache');
			$config->setProxyNamespace('Proxies');
			$config->setDefaultDB("merlin");
			$config->setHydratorDir(self::$basePath . 'cache');
			$config->setHydratorNamespace('Hydrators');

			$reader = new AnnotationReader();
			$reader->setDefaultAnnotationNamespace('Doctrine\ODM\MongoDB\Mapping\\');
			
			//add all document paths for all plugins/modules
			$documentPaths = array(
				self::$basePath."app/SiegePerilousStudios/Merlin/ManagedRouter/Model"
			);
			
			
			$config->setMetadataDriverImpl(new AnnotationDriver($reader,$documentPaths));

			$dm = DocumentManager::create(new Connection(), $config);

			$this->database=$dm;
		}
		return $this->database;
	}

}