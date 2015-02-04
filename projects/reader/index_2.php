<!DOCTYPE HTML>

<html>
<head>
	<title>Nibz Reader</title>
	<meta name="description" content="A small, web-based feed aggragation service." />
	<meta name="author" content="Bill 'Vagabond Azulien' Nibz" />
	
	<link rel="stylesheet" type="text/css" href="reader.css" />
	<script type="text/javascript" src="../../doodads/jquery.js"></script> 
	<script type="text/javascript" src="reader.js"></script>
	<?php $dbhandle = mysqli_connect("localhost", "billn", "fatty119", "internetvagabond"); ?>
</head>
<body>

<header id="title" class="mainheader">
	<div class="maintitle">The Nibz Reader</div>
	<ul class="feedbuttons">
		<li id="feed_refresh"></li>
		<li id="feed_add"></li> 
		<li id="feed_help"></li>
	</ul>
</header>	
<!--  Feed Aggrigation Section -->
	<section id="reader" class="reader">
		<header id="rss_actions" class="r_actions">
			<!-- refresh, add feed, import/export button?, others -->
		</header>
		<div id="feedlist" class="feeds">
			<!-- list feeds and current unread articles here -->
		</div>
		<div id="feedinfo" class="articles">
			<!-- this section gets populated via php -->
		</div>
	</section>
<!-- Read Later Section -->
	
	<?php include 'readlater.php'; ?>

</body>
</html>
