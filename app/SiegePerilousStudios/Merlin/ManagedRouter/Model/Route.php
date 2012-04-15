<?php

namespace SiegePerilousStudios\Merlin\ManagedRouter\Model;
/**
 *
 * @Document
 */
class Route {
	
	/** @Id(strategy="AUTO") */
	public $id;
	
	/** @String */
	public $uri;
	
	/** @String */
	public $handlerName;
	
	/** @String */
	public $title;
	
	/** @String */
	public $description;
	
	/** @Collection */
	public $keywords = array();
	
	/** @String */
	public $language;
	
	/** @String */
	public $status;
	
	/** @String */
	public $authorisation;
	
}