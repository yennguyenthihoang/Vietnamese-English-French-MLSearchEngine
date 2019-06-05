<html>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script language="javascript">
var g_token = '';

function onLoad() {
  // Get an access token now.  Good for 10 minutes.
  getToken();
  // Get a new one every 9 minutes.
  setInterval(getToken, 9 * 60 * 1000);
  alert('asdfsadffsdf');
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

function translate(text, from, to) {
  var p = new Object;
  p.text = text;
  p.from = from;
  p.to = to;

  // A major puzzle solved.  Who would have guessed you specify the jsonp callback in oncomplete?
  p.oncomplete = 'ajaxTranslateCallback';
  
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

function ajaxTranslateCallback(response) {
  // Display translated text in the right textarea.
  $("#target").text(response);
}

function translateSourceTarget() {
  // Translate the text typed by the user into the left textarea.
  var src = $("#source").val();
  translate(src, "en", "fr");
}
</script>
<style>
#source, #target {
  position:relative;
  float:left;
  width:400px;
  height: 50px;
  padding:10px;
  margin: 10px;
  border: 1px solid black;
}

#translateButton {
  float:left;
  margin: 10px;
  height:50px;
}
</style>
</head>

<body onload="onLoad();">

<textarea id="source">Text typed here will be translated.</textarea>
<button id="translateButton" onclick="translateSourceTarget();">Translate English to French</button>
<textarea id="target"></textarea>

</body>
</html>