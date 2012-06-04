<?php


namespace SiegePerilousStudios\Merlin\Blog\Model;

use \Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Description of BlogPost
 *
 * @author alisdairrankine
 * @ODM\Document
 */
class BlogPost {
	
	/** @ODM\Id(strategy="AUTO") */
	public $id;
	
	public $title;
	
	public $summary;
	
	public $content;
	
	public $drafts;
	
	public $createdDate;
	
	public $editDate;
	
	public $tags;
	
	public $status;
}
