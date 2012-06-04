<?php

namespace SiegePerilousStudios\Merlin\Admin;
/**
 * Description of AdminHandler
 *
 * @author alisdairrankine
 */
class AdminHandler extends \SiegePerilousStudios\Merlin\ManagedRouter\RouteHandler{
	
	public function route(){
		
		$this->globalTemplate = "admin/global.twig";
		
		return $this->render();
		
	}
}

?>
