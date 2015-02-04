<html>
<head>
	<title>Hero Mash Up -- Week 1</title>
	<meta name="author" content="Bill 'Vagabond Azulien' Nibz" />
	
	<link rel="stylesheet" type="text/css" href="hmu_styles.css" />
	<script type="text/javascript" src="/../doodads/jquery.js"></script>
	<script type="text/javascript" src="/../doodads/vagabondsigns.js"></script>
	<script type="text/javascript" src="hmu_scripts.js"></script>
	
</head>
<body>

	<!-- Header section of the page -->
	
	<div class="header">
		<div class="title_cont">
			<div class="title"><span class="btitle">H</span>ERO <span class="btitle">M</span>ASH <span class="btitle">U</span>P!</div>
			<hr class="utitle" />
			<div class="stitle">CURRENT FIGHT &rarr;</div>
		</div>
		<div class="current_cont">
			<div class="current">
				<div class="current_team" id="team1">TEAM 1: Cool Guy</div>
				<div class="current_vs">VS</div>
				<div class="current_team" id="team2">TEAM 2: Bad Dude</div>
				<div class="clean"></div>
				<div class="current_arena" id="current_arena">Arena: Amherst Central High School</div>
			</div> 
		</div>
	<div class="clean"></div>
	</div>
	
	<!-- Main Section of the page -->
	
	<div class="torso">
		<ul class="menu_cont">
			<li class="menu_item" id="stories">Story</li>
			<li class="menu_item" id="heroes">Heroes</li>
			<li class="menu_item" id="teams">Teams</li>
			<li class="menu_item" id="arenas">Arenas</li>
			<li class="menu_item" id="brackets">Brackets</li>
			<li class="menu_item" id="betting">Log-In</li>
		</ul>
		<div class="clean"></div>
		<div class="main" id="main_area">
			<?php require("stories.php") ?>
		</div>
	</div>
	
	<!-- Standard TIV footer -->
	
	<div class="tiv_footer">
		<div class="tiv_footer_notice">
			<div id="vagabond_notice" class="tiv_footer_notice_text" onClick="cycleArray()">The Internet Vagabond &copy 2009-2012</div>
		</div>
	</div>
</body>
</html>