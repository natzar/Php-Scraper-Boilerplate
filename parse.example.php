<?
/*
@ Betolopezayesa@gmail.com
@ 8/05/2016
@ Template for simple scrapers Php + Simple Html Dom.
@ Input: URL with events
@ Output: Array Events

Please download simplehtmldom from: http://simplehtmldom.sourceforge.net/
ONLINE DOCUMENTATION IN THE SAME PAGE.

Template Array for 1 EVENT
array(
            "title" => "", String
            "description" => "", String
            "dateEvent" => "",  Y-m-d String
            "dateEventEnd" => "", Y-m-d String  (if exists)
            "rawDate" => "", The string that contains Raw Date
            "hourEvent" => "", military time 00:00 - 23:59 (if exists)
            "city" => "",  Default: Barcelona
            "imagen" => "",    File image url   (if exists) 
            "location" => "",  String 
            "address" => "",  String    (if exists) 
            "lat" => "", String (if exists)
            "lng" => "", String if exists       
            "price" => "",  number  (if exists)
            "source" => "",  Scraping Source URL 
            "url" => "",  Event URL (if exists)
            "youtubeUrl" => "",  Youtube URL (if exists)
        );
*/


/* SAMPLE FOR http://www.barcelona-metropolitan.com/search/event/upcoming-events/ */

include_once dirname(__FILE__)."/simplehtmldom_1_9_1/simple_html_dom.php";


$events = array();


$URLS = array("https://seatgeek.com/cities/sf/sports");
$TAGS = array("sports-events");
$i=0;
foreach($URLS as $url){
      $html = file_get_html($url);
      extractEvents($html,$TAGS[$i]);
      sleep(5);
      $i++;
}


function extractEvents($html,$TAG){
      global $events;
      
$SOURCE = "scraping_seatgeek";
$AREA = "san-francisco";

foreach($html->find('script') as $script) {
  
  // Unfinished example. dateEvent / hourEvent is missing.
  // FIX need to pre-process Date, to explode [DATE, TIME]

      // Do something with $event ... 
      // print_r($event);

$x = json_decode($script->innertext);

if (isset($x->name) and isset($x->location->address) and isset($x->endDate) and isset($x->startDate)){

$aux = explode("T",$x->startDate);
$time = $aux[1];
$start_date = $aux[0];


      $item = array(
            "submit" => 1,
            "title" => $x->name,
            "description" => $x->description,
            "start_date" => $start_date,  
            "end_date" => $x->endDate, 
            "start_time" => $time,
            "city" => $x->location->address->addressLocality,
            "area" =>  $AREA,           
            "venue" =>  $x->location->name,
            "address" => $x->location->address->streetAddress,
            "price" => $x->offers->lowPrice." - ".$x->offers->lowPrice,
            "tags" => $TAG,
            "source" => $SOURCE, 
            "url" => $x->url,  
            
      );
 
    $events[] = $item;

  
}
}
}

foreach($events as $event){

// set post fields
$post = $event;

$ch = curl_init('https://www.airovic.com/submit-new-event.html');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

// execute!
$response = curl_exec($ch);

// close the connection, release resources used
curl_close($ch);

// do anything you want with your response
var_dump($response);


}

