<?
/*
@ Betolopezayesa@gmail.com
@ 8/05/2016
@ Template for simple scrapers Php + Simple Html Dom.
@ Input: URL with events
@ Output: Array Events

https://simplehtmldom.sourceforge.io/manual.htm

*/


include_once dirname(__FILE__)."/simplehtmldom_1_9_1/simple_html_dom.php";
include_once dirname(__FILE__)."/Request.php";
libxml_use_internal_errors( 1 ); 
$events = array();
$req = new Request();
$URL = "PUT YOUR URL HERE";
$AREA = "miami";
$TAGS = array("TAG"); // TAG needed art-exhibitions, music...
$SOURCE = "scraping";


function extractEvents($html){
  global $events, $TAGS, $AREA;

  foreach($html->find('div.elements-area .item') as $item) {

    $title = $item->title;
    $description = $item->desc;
    $start_date = $item->item;
    $time = $item->item;
    $end_date = $item->item;
    $city = $item->item;
    $venue = $item->item;
    $address = $item->item;
    $price = $item->item;
    $url = $item->item;

    $item = array(
          "submit" => 1,
          "title" => $x->name,
          "description" => $description,
          "start_date" => $start_date,  
          "end_date" => $end_date,
          "start_time" => $time,
          "city" => $city,
          "area" =>  $AREA,           
          "venue" =>  $venue,
          "address" => $address,
          "price" => $price,
          "tags" => $TAG,
          "source" => $SOURCE, 
          "url" => $url,  
        
    );

    $events[] = $item;
  }
}

$html = $req->wget($url);

$dom = new DOMDocument();
$result = $dom->loadHTML($html, LIBXML_NOERROR);
$result2 = $result;

$html =  str_get_html($dom->loadHTML($result2));

extractEvents($html);




print_r($events);

