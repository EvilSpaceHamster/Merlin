<?php

namespace SiegePerilousStudios\Merlin;

use Symfony\Component\HttpFoundation\Request;

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
	
	public $response;
	
	
	public function __construct(){
		//whatever
		
		$this->generateRequest();
	}
	
	private function generateRequest(){
		$this->request = Request::createFromGlobals();
	}
	
	/**
	 *
	 * @return Symfony\Component\HttpFoundation\Request 
	 */
	public function getRequest(){
		if (empty($this->request)){
			$this->generateRequest();
		}
		
		return $this->request;
	}
	
	public function redirectToLoginPage(){
		$this->redirect("/login/");
	}
	
	
	
	private function redirect($uri);
	
	public function run(){
		echo "HELLO".$this->request->getRequestUri();exit;
		/*
		$url = $this->request->getUri();
		$handlerName = $this->findHandlerForURI($url);
		if ($handlerName!==false){
			$handler = new $handlerName($this);
		}
		*/
		
		
	}
	
	
	
	
	private function findHandlerForURI($uri){
		$handler; //= getHandler...
		if (!empty($handler)){
			return $handler;
		}
		$subUri; //= uri down a level
		if ($subUri===false){
			return false;
		}
		
		return findHandlerForUri($subUri);
		
	}
	
	public function hasClearance($authorisation){
		$acl;//get acl instance from authorisation name
	
		//if user has authorisation in acl
			return true;
			
			
		//else;
			return false;
		
	}
	
	
	
	
}