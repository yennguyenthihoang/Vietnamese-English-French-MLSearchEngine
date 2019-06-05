<?php

if(isset($_GET["keyword"]))
{
	$query= $_GET["keyword"];
}
else 
{
	$query= 'Nikita%20Platonenko';
}

$accountKey = 'd4KkuG0SmXHGbooAqIOlMCqK9Dedv7VhmOKRyNXeu4s';

$auth = base64_encode("$accountKey:$accountKey");

$data = array(
  'http'            => array(
  'request_fulluri' => true,
  'ignore_errors'   => true,
  'header'          => "Authorization: Basic $auth")
);

$context   = stream_context_create($data);
$query     = isset($_GET['q']) ? $_GET['q'] : $query;
$serviceOp = isset($_GET['sop']) ? $_GET['sop'] : 'Web';
$market    = isset($_GET['market']) ? $_GET['market'] : 'en-us';

$ServiceRootURL = 'https://api.datamarket.azure.com/Bing/Search/';  
$WebSearchURL   = $ServiceRootURL . 'Web?$format=json&Query=';

$request = $WebSearchURL . urlencode( '\'' . $query. '\'');

// Get the response from Bing.
$body = file_get_contents($request, 0, $context);
$json = json_decode($body);

for($x=0;$x<5;$x++){
	echo "<b>Result ".($x+1)."</b>";
	echo "<br>Display URL: ";
	echo $json->d->results[$x]->DisplayUrl;
	echo "<br>URL: ";
	echo $json->d->results[$x]->Url;
	echo "<br>Title: ";
	echo $json->d->results[$x]->Title;
	echo "<br>Content: ";
	echo $json->d->results[$x]->Description;
	echo "<br><br>";
}

?>