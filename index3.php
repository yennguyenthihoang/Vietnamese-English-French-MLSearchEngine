<html>
<head>
   <link href="styles.css" rel="stylesheet" type="text/css" />
 <title>PHP Bing</title>
</head>
<body>
<form method="post"> 
 Type in a search:
 <input type="text" id="searchText" name="searchText" value="sushi"/>
 <input type="submit" value="Search!" name="submit" id="searchButton" />
	<?php
	if (isset($_POST['submit'])) {
	$request = 'http://api.search.live.net/json.aspx?Appid=d4KkuG0SmXHGbooAqIOlMCqK9Dedv7VhmOKRyNXeu4s&sources=image&query=' . urlencode( $_POST["searchText"]);
	$response  = file_get_contents($request);
	$jsonobj  = json_decode($response);	
	echo('<ul ID="resultList">');                    
				
	foreach($jsonobj->SearchResponse->Image->Results as $value)
	{
	echo('<li class="resultlistitem"><a href="' . $value->Url . '">');
	echo('<img src="' . $value->Thumbnail->Url. '"></li>');
	}
	echo("</ul>");
	} 
	?>
</form>
</body>
</html>