<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Multiple Languages Search Engine</title>
<meta name="keywords" content="imusic, CSS, XHTML" />
<meta name="description" content="iMusic -" />
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" language="javascript">
		var xmlHttp;
		var xmlHttp2;
		var xmlHttp3;
		
		var chkSystem= "" ;
		var g_token = '';
		
		var full_langs = ["English", "French", "Vietnamese"];
		var langs = ["en", "fr", "vi"];
		var to_lang = [0, 1];
		var ol_idx = 0;
		
		var queries = new Array();

		function onLoad() {
		  document.getElementById('ol_en').checked = true;
		  // Get an access token now.  Good for 10 minutes.
		  getToken();
		  // Get a new one every 9 minutes.
		  setInterval(getToken, 9 * 60 * 1000);
		}

		function getToken() {
		  var requestStr = "./token.php";

		  $.ajax({
			url: requestStr,
			type: "GET",
			cache: true,
			dataType: 'json',
			success: function (data) {
			  g_token = data.access_token;
			}
		  });
		}
		
		function CreateXMLHttpRequest()
		{
			if ( window.XMLHttpRequest )
			{
				 // code for IE7+, Firefox, Chrome, Opera, Safari
				return new XMLHttpRequest()
			}
			else if (window.ActiveXObject )
			{
				 // code for IE6, IE5
				return new ActiveXObject("Microsoft.XMLHTTP")
			}
		}
		
		function showResult()
		{
			
			if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
			{
				var kq = xmlHttp.responseText;
				document.getElementById("center_column").innerHTML += "<h2>" + full_langs[ol_idx] + ": " + queries[0] + "</h2><br>";
				document.getElementById("center_column").innerHTML += kq;		
			}
		}

		function showResult2()
		{
			if(xmlHttp2.readyState == 4 && xmlHttp2.status == 200)
			{
				var kq = xmlHttp2.responseText;
				document.getElementById("center_column").innerHTML += "<h2>" + full_langs[to_lang[0]] + ": " + queries[1] + "</h2><br>";
				document.getElementById("center_column").innerHTML += kq;
			}
		}
		function showResult3()
		{
			if(xmlHttp3.readyState == 4 && xmlHttp3.status == 200)
			{
				var kq = xmlHttp3.responseText;
				document.getElementById("center_column").innerHTML += "<h2>" + full_langs[to_lang[1]] + ": " + queries[2] + "</h2><br>";
				document.getElementById("center_column").innerHTML += kq;
			}
		}
		
	
		function btnSearch()
		{
			document.getElementById("center_column").innerHTML = "";
			if(document.getElementById('ol_en').checked) {
				ol = "en";
			}else if(document.getElementById('ol_fr').checked) {
				ol = "fr";
			} else {
				ol = "vi";
			}
			
			
			cnt = 0;
			
			for (var i=0;i<langs.length;i++)
			{
				if (langs[i] == ol)
				{
					ol_idx = i;
				}
				else
				{
					to_lang[cnt] = i;
					cnt += 1;
				}
			}
		
			
			
			xmlHttp = CreateXMLHttpRequest();
			xmlHttp.onreadystatechange = showResult;
			var keyword = document.getElementById('keyword').value;
			var serverURL = "http://localhost:8080/MLSearchEngine/search_bing.php?keyword="+ encodeURI(keyword);
			xmlHttp.open("get", serverURL, true);
			xmlHttp.send();
			
			
			
			queries[0] = keyword;
			
			// search in VI
			//alert(langs[to_lang[1]]);
			translate(keyword, ol, langs[to_lang[0]], 'ajaxTranslateCallback2')
			translate(keyword, ol, langs[to_lang[1]], 'ajaxTranslateCallback3')
		}
		
		
		function translate(text, from, to, callback_func) {
		  var p = new Object;
		  p.text = text;
		  p.from = from;
		  p.to = to;
		  
		  // A major puzzle solved.  Who would have guessed you specify the jsonp callback in oncomplete?
		  p.oncomplete = callback_func;
		 // Another major puzzle.  The authentication is supplied in the deprecated appId param.
		  p.appId = "Bearer " + g_token;

		  var requestStr = "http://api.microsofttranslator.com/V2/Ajax.svc/Translate";

		  $.ajax({
			url: requestStr,
			type: "GET",
			data: p,
			dataType: 'jsonp',
			cache: true
		  });
		}
		
		
		function ajaxTranslateCallback2(response) {
		
			// Display translated text in the right textarea.
			xmlHttp2 = CreateXMLHttpRequest();
			xmlHttp2.onreadystatechange = showResult2;
			var serverURL = "http://localhost:8080/MLSearchEngine/search_bing.php?keyword="+ encodeURI(response);
			xmlHttp2.open("get", serverURL, true);
			xmlHttp2.send();
			queries[1] = response;
		}
		
		function ajaxTranslateCallback3(response) {
			// Display translated text in the right textarea.
			xmlHttp3 = CreateXMLHttpRequest();
			xmlHttp3.onreadystatechange = showResult3;
			var serverURL = "http://localhost:8080/MLSearchEngine/search_bing.php?keyword="+ encodeURI(response);
			xmlHttp3.open("get", serverURL, true);
			xmlHttp3.send();
			queries[2] = response;
		}
		
</script>

<body onload="onLoad();">
<div id="container_wrapper">
	<div id="container">
		<div id="top">
        <br />
        </div>
		<div id="header">
		</div>
		
		<div id="menuleft"></div>    
		<div id="menu">
		</div>
		
		<div id="content">
			<div id="left_column">
				<div class="section2">
					<h1>Search</h1>
                    <h2>Keyword</h2></b> <input type="text" id='keyword' style="width:174px" /><br />
                    <input class="button" type="button"value="Search" name="btnSearch" onclick='btnSearch();' /><br /><br/>
					<h1>Original Language</h1> </b>
					<form>
						<input type="radio" name="ori_lang" id ="ol_en" value="en">English<br>
						<input type="radio" name="ori_lang" id ="ol_fr" value="fr">French<br>
						<input type="radio" name="ori_lang" id ="ol_vi" value="vi">Vietnamese
					</form><br />
				</div>
			</div>
			
			<div id="center_column">
			</div>
		</div>	
		
		<div id="footer">
			<a href="#">Home</a> | <a href="#">Insert Album</a> | <a href="#">Insert Song</a> | <a href="#">Search</a>
            <div align=center"><b><font color="white"> Copyright © 2013 Nguyen Thi Hoang Yen | 1012550</font></b> </div>
		</div>
		
	</div>
</div>
</body>
</html>