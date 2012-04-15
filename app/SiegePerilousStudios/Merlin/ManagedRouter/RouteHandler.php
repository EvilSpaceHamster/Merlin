<?php


namespace SiegePerilousStudios\Merlin\ManagedRouter;
/**
 * Description of RouteHandler
 *
 * @author alisdairrankine
 */
abstract class RouteHandler {
	
	/**
	 *
	 * @var SiegePerilous\Merlin\Application
	 */
	protected $app;
	
	protected $templateEnvironment;
	
	protected $templateVariables;
	
	protected $templateFile;
	
	protected $globalTemplate;
	
	public function __construct(&$app){
		$this->app = $app;
		$this->getTemplateEnvironment();
	}
	
	abstract public function route();
	
	
	protected function preparePage(){
		$page = array();
		$page["title"] = $this->app->route->title;
		$page["description"] = $this->app->route->description;
		$page["keywords"] = implode(",",$this->app->route->keywords);
		$page["staticURL"] = $this->app->staticURL;
		$page["baseURL"] = $this->app->baseURL;
		$page["currentURL"] = $this->app->route->uri;
		$page["appState"] = $this->app->appState;
		$this->templateVariables["page"]=$page;
	}
	
	protected function getTemplateEnvironment(){
		if (empty($this->templateEnvironment)){
			$this->preparePage();
			$loader = new \Twig_Loader_Filesystem($this->app->basePath."templates");
			$twig = new \Twig_Environment($loader, array(
				"cache" => $this->app->basePath."cache",
				"debug" => (($this->app->appState=="debug")? true : false)
			));
			$this->templateEnvironment = $twig;
		}
		return $this->templateEnvironment;
	}
	
	protected function render(){
		if (empty($this->globalTemplate)){
			throw new \Exception("No global template available");
		}
		if (!empty($this->templateFile)){
			$this->templateVariables["templateFile"] = $this->templateFile;
		}
		return $this->templateEnvironment->render($this->globalTemplate,$this->templateVariables);
	}
}

?>
