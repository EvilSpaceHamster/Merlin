<?php
$file = file_get_contents("http://www.bench.co.uk/feeds/affiliate_window.php");

echo "file fetching..... [OK]<br/>";

$xml = simplexml_load_string($file);
//var_dump($xml);
$categories=array();
$conn = new Mongo();
$db  = $conn->merlinEcom;
$products = $db->products;
$products->remove();
$db->categories->remove();

foreach($xml->children() as $product){
	$record = array();
	$category="";
	foreach($product->children() as $attr){
		switch($attr->getName()){
			case "thumburl":
				$record["thumb"] = strip_tags($attr->asXML());
				break;
			case "name":
				$record["name"] = strip_tags($attr->asXML());
				break;
			case "modelno":
				$style_colour=explode(" ",$attr);
				$record["style_code"]=$style_colour[0];
				$record["colour_code"]=$style_colour[1];
				break;
			case "pid":
				$record["ean"]=strip_tags($attr->asXML());
				break;
			case "category":
				$catName=$attr->asXML();
				$category = strip_tags($catName);
		}
	}
	echo $record["name"]."<br/>";
	$products->insert($record);
	$categories[$category]["products"][] = array(
		"name"   => $record["name"],
		"img"    => $record["thumb"],
		"style"  => $record["style_code"],
		"colour" => $record["colour_code"]
	);
}
$cats = $db->categories;
foreach ($categories as $catName => $cat){
	$cat["name"]=$catName;
	$cat["url"] =strtolower(str_replace(" ","-",urlencode($catName)));
	$cats->insert($cat);
}
echo "<pre>";
var_dump($categories);
echo "</pre>";




?>
