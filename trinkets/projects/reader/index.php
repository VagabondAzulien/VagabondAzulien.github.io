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
	<section id="later" class="later">
		<header id="title">Read Later</header>
		<nav id="actions">
			<!-- refresh, add, others -->
			<div id="rl_add" onclick="addRL(url, title)">Add</div>
			<div id="rl_sort">Sort</div>
			<div id="rl_list">Lists</div>
			<div id="clear"></div> 
		</nav>
		<div id="readlist" class="readlist">
			<?php
				if (mysqli_connect_errno($dbhandle)){ echo "Failed to connect: " . mysqli_connect_error();}
				
				$query = mysqli_query($dbhandle, "SELECT * FROM readlater ORDER BY add_date DESC");
				while ($entry = mysqli_fetch_array($query)) {?>
					<div id="article">
						<div id="a_date"><?php
						 	$tempDate = date('M. j H:G', strtotime(str_replace('.','-',$entry['add_date'])));
							echo $tempDate;?></div>
						<div id="a_opts">
							<span id="a_opts_list">[+]</span>
							<span id="a_opts_del">[X]</span>
						</div>
						<div id="clear"></div>
						<div id="a_title"><?php echo $entry['title'];?></div>
						<div id="a_link"><?php echo $entry['url'];?></div>
					</div>
			<?php } ?>
		</div>
	</section>
</body>
</html>
