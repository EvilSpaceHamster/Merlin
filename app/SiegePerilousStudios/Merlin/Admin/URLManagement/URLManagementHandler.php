<?php

namespace SiegePerilousStudios\Merlin\Admin\URLManagement;

/**
 * Description of URLManagementHandler
 *
 * @author alisdairrankine
 */
class URLManagementHandler extends \SiegePerilousStudios\Merlin\ManagedRouter\RouteHandler{
	
	public function route(){
				
		
		
		
		$dm = $this->app->getDatabase();
		
		$routes = $dm->createQueryBuilder('\SiegePerilousStudios\Merlin\ManagedRouter\Model\Route')
				->sort("uri")
				->getQuery()
				->execute();
		
		
		$this->templateVariables["routes"]=$routes;
		
		
		$this->globalTemplate = "admin/global.twig";
		$this->templateFile = "admin/URLManagement/index.twig";
		return $this->render();
	}
}