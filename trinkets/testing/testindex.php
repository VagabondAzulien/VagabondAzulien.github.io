<!DOCTYPE HTML>
<html>
<head>
	<title>Test Index</title>
	<meta name="description" content="The rants of the wandering computer scientist, constantly in search of truth, knowledge, and a decent ping." />
	<meta name="keywords" content="internet, vagabond" />
	<meta name="author" content="Bill 'Vagabond Azulien' Nibz" />
	
	<link rel="stylesheet" type="text/css" href="testcamo.css" />
	<script type="text/javascript" src="jquery.js"></script> 
	<script type="text/javascript" src="test.js"></script>
	<script type="text/javascript">
		window.addEventListener('DOMContentLoaded', function() {
			// Assign the <audio> element to a variable
			var audio = document.getElementById('voip');

			// Replace the source of the audio element with the stream from the microphone
			if (navigator.getUserMedia) {
				navigator.getUserMedia({audio: true}, successCallback, errorCallback);
				function successCallback(stream) {
					audio.src = stream;
				}
				function errorCallback(error) {
					console.error('An error occurred: [CODE ' + error.code + ']');
					return;
				}
			} else {
				console.log('Native microphone streaming (getUserMedia) is not supported in this browser.');
				return;
			}
		}, false);
	</script>
</head>
<body>
	<header class="header">
		<div class="header_title"><div class="header_title_word">THE</div> <div class="header_title_word">INTERNET</div> <div class="header_title_word">VAGABOND</div></div>

	</header>	
	
	<div class="main">	
		
		<br /><br /><br /><br /><br />
	
		<div class="main_posts">
		
				<!-- This section contains the pulled-in posts from multiple sources that compose the main content of the page -->
			
			<div class="text_post" id="gplus">
				<input id="ptt" type="button" value="Push To Talk" />
				<audio id="voip" controls="controls" autoplay>If this doesn't work, you should upgrade your browser.</audio>
			</div>
			
		</div>
	</div>
</body>
</html>	