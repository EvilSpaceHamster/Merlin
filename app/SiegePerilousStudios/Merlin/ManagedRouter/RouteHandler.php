<?php


namespace SiegePerilousStudios\Merlin\ManagedRouter;
/**
 * Description of RouteHandler
 *
 * @author alisdairrankine
 */
abstract class RouteHandler {
	
	protected $app;
	
	protected $templateVariables;
	
	public function __construct(&$app){
		$this->app = $app;
	}
	
	abstract public function route();
	
	
	protected function preparePage(){
		$page = array();
		$page["title"] = $this->app->route->title;
		$page["description"] = $this->app->route->description;
		$page["keywords"] = implode(",",$this->app->route->keywords);
		$page["staticURL"] = $this->app->staticURL;
		$page["currentURL"] = $this->app->route->uri;
		$this->templateVariables["page"]=$page;
	}
}

?>
