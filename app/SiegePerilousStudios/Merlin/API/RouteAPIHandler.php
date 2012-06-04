<?php

namespace SiegePerilousStudios\Merlin\API;

/**
 * Description of Route
 *
 * @author alisdairrankine
 */
class RouteAPIHandler extends \SiegePerilousStudios\Merlin\ManagedRouter\RouteHandler {

	public function route() {
		$dm = $this->app->getDatabase();
		$method = $this->app->getRequest()->getMethod();
		$this->app->mime = "application/json";
		switch ($method) {
			case "GET":
				//change this to use URL
				$id = $this->app->getRequest()->query->get("id");
				if (!empty($id)) {
					$route = $dm->find("SiegePerilousStudios\Merlin\ManagedRouter\Model\Route", $id);
					return json_encode($route);
				}
				$this->app->status = 501;
				return json_encode(array("error" => "Method Not implemented"));
			case "POST":
				$id = $this->app->getRequest()->request->get("id");
				$title = $this->app->getRequest()->request->get("title");
				$uri = $this->app->getRequest()->request->get("uri");
				$description = $this->app->getRequest()->request->get("description");
				$keywords = $this->app->getRequest()->request->get("keywords");
				$handlerName = $this->app->getRequest()->request->get("handlerName");

				$authorisation = $this->app->getRequest()->request->get("authorisation");

				if (!empty($id)) {
					$route = $dm->find("SiegePerilousStudios\Merlin\ManagedRouter\Model\Route", $id);
				} else {
					$route = new \SiegePerilousStudios\Merlin\ManagedRouter\Model\Route();
				}
				if ($route->authorisation != "readonly") {
					try{
					if (!empty($title))
						$route->title = $title;
					if (!empty($uri))
						$route->uri = $uri;
					if (!empty($description))
						$route->description = $description;
					if (!empty($keywords))
						$route->keywords = explode(",", $keywords);
					if (!empty($handlerName))
						$route->handlerName = $handlerName;
					if (!empty($authorisation))
						$route->authorisation = $authorisation;
					
					$dm->persist($route);
					$dm->flush();					
					return json_encode($route);
					} catch (\Exception $e) {
						$this->app->status = 500;
						return json_encode(array("error"=>$e->getMessage()));
					}
				} else {
					$this->app->status = 403;
					return json_encode(array("error" => "Access Denied"));
				}
		}
		$this->app->status = 501;
		return json_encode(array("error" => "Method Not implemented"));
	}

}

?>
