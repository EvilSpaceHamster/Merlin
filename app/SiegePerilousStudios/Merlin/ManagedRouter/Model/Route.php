<?php

namespace SiegePerilousStudios\Merlin\ManagedRouter\Model;

use \Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 *
 * @ODM\Document
 */
class Route {
	
	/** @ODM\Id(strategy="AUTO") */
	public $id;
	
	/** @ODM\String @ODM\Index */
	public $uri;
	
	/** @ODM\String */
	public $handlerName;
	
	/** @ODM\String */
	public $title;
	
	/** @ODM\String */
	public $description;
	
	/** @ODM\Collection */
	public $keywords = array();
	
	/** @ODM\String */
	public $language;
	
	/** @ODM\String */
	public $status;
	
	/** @ODM\String */
	public $authorisation;
	
}