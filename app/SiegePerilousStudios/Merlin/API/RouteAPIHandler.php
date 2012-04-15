<?php

namespace SiegePerilousStudios\Merlin\API;

/**
 * Description of Route
 *
 * @author alisdairrankine
 */
class RouteAPIHandler extends \SiegePerilousStudios\Merlin\ManagedRouter\RouteHandler {
	public function route(){
		$method = $this->app->getRequest()->getMethod();
		switch ($method){
			case "GET":
				
				//change this to use URL
				$id = $this->app->getRequest()->query->get("id");
				$route = $this->app->getDatabase()->find("SiegePerilousStudios\Merlin\ManagedRouter\Model\Route", $id);
				echo json_encode($route);
				exit;
		}
	}
}

?>
