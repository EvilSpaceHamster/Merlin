<?php
$conn= new Mongo();
$db = $conn->merlinEcom;
$cats = $db->categories;
$category=false;
$output ="";
$active = "";
if (isset($_SERVER["PATH_INFO"])){
	$category = $cats->findOne(array("url" => substr($_SERVER["PATH_INFO"],1)));
}
$cl = $cats->find(array(),array("url","name"));
$cl->sort(array("name"=>1));
if ($category){
	$active= " - ".$category["name"];
	foreach ($category["products"] as $product){
		$output.= "<img src=\"{$product["img"]}\"/>";
		 $output.=  "<h3>{$product["name"]}</h3>";
		 $output.= "<br/><br/>";
	}
}

$menu= "<ul>";
foreach ($cl as $link){
        if ($link["name"]==$category["name"]){
                $class="class=\"active\"";
                $linky="";
        } else {
                $class="";
                $linky="href=\"http://contentbymerlin.com/merlin_ecom/category.php/{$link["url"]}\"";
        }

        $menu.= "<li><a $class $linky>{$link["name"]}</a></li>";
}
$menu.= "</ul>";





$tpl = file_get_contents("views/main.html");
$vars= array(
 "menu" => $menu,
 "title" => "Merlin eCommerce".$active,
 "content" => $output
);

foreach($vars as $var=>$val){
	$tpl = str_replace("{{".$var."}}",$val,$tpl);
}

echo $tpl;
?>
