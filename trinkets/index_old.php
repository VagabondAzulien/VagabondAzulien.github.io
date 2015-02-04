<!DOCTYPE HTML>
<html>
<head>
	<title>The Internet Vagabond :: Home</title>
	<meta name="description" content="The rants of the wandering computer scientist, constantly in search of truth, knowledge, and a decent ping." />
	<meta name="keywords" content="internet, vagabond" />
	<meta name="author" content="Bill 'Vagabond Azulien' Nibz" />
	
	<link rel="stylesheet" type="text/css" href="doodads/vagabondcamo.css" />
	<script type="text/javascript" src="doodads/jquery.js"></script>
	<script type="text/javascript" src="doodads/vagabondsigns.js"></script>
</head>
<body>
	<header class="header">
		<!-- Simple top-of-page filler -->
		<div class="header_title">The Internet Vagabond</div>
		<div class="header_sub">In search of truth, knowledge, and a decent ping</div>
		<!-- Navbar area -->
		<ul class="navbar">
			<li class="navlink" id="news">News</li>
			<li class="navlink" id="adv">Adventures</li>
			<li class="navlink" id="exp">Experiences</li>
			<li class="navlink" id="about">About</li>
		</ul>
	</header>
	
<!-- New Footer area -->
	<div class="footer">
		<div class="footer_notice">
			<div id="vagabond_notice" class="footer_notice_text" onClick="cycleArray()">The Internet Vagabond &copy 2009-2012</div>
		</div>
	</div>
<!-- End New Footer area -->
<!--
	<footer class="footer">
		<div class="foot_left">
			<!-- This element contains links to the 4 major parts of the website
			<img class="footer_img" src="trinkets/h_d.png" onmouseover="this.src='trinkets/h_c.png'" onmouseout="this.src='trinkets/h_d.png'" alt="Go Home" />
			<img class="footer_img" src="trinkets/v_d.png" onmouseover="this.src='trinkets/v_c.png'" onmouseout="this.src='trinkets/v_d.png'" alt="Go Adventuring" />
			<img class="footer_img" src="trinkets/e_d.png" onmouseover="this.src='trinkets/e_c.png'" onmouseout="this.src='trinkets/e_d.png'" alt="Get some sweet Exp" />
			<img class="footer_img" src="trinkets/a_d.png" onmouseover="this.src='trinkets/a_c.png'" onmouseout="this.src='trinkets/a_d.png'" alt="Learn some stuff" />
		</div>
		<div class="foot_center">
			<!-- This element contains information regarding the website
			<div class="footer_info">The Internet Vagabond, Inc. 2010</div>
			<div class="footer_info">Coded in <a href="http://notepad-plus-plus.org">Notepad++</a>. Optimized for <a href="http://www.opera.com">Opera</a></div>
		</div>
		<div class="foot_right">
			<!-- This element contains links to me on various social sites: twitter, Facebook, LinkedIn, Last.fm, etc...
			<a href="http://www.facebook.com/theinternetvagabond"><img class="footer_img" src="trinkets/fb_icon.png" alt="Facebook" /></a>
			<a href="http://www.linkedin.com/in/bdniblock"><img class="footer_img" src="trinkets/li_icon.png" alt="LinkedIn" /></a>
			<a href="http://www.google.com/profiles/Azulien"><img class="footer_img" src="trinkets/gb_icon.png" alt="Google+" /></a>
			<a href="http://twitter.com/Azulien"><img class="footer_img" src="trinkets/t_icon.png" alt="Twitter" /></a>
			<a href="mailto:internet_vagabond@hotmail.com"><img class="footer_img" src="trinkets/em_icon.png" alt="Email" /></a>
		</div>
	</footer>
 
	<div class="leftbar">
		<!-- Acts as a pseudo-menu of additional content: ongoing projects, additional sites, and favorite/suggest links.
		<div>
			<h2 class="left_title">Projects</h2>
				<ul class="leftlist">
					<li>Chromed Tunes</li>
					<li>Project Management System</li>
					<li>Cloudport: The Social Bazaar</li>
					<li>Nitro Page</li>
				</ul>
		</div>
		<hr class="left_sep" />
		<div>
			<h2 class="left_title">Sub-Sites</h2>
				<ul class="leftlist">
					<li>[EXP] Guild Forums</li>
					<li>Hope Guild Forums</li>
					<li>The Forever Men</li>
				</ul>
		</div>
		<hr class="left_sep" />
		<div>
			<h2 class="left_title">Links</h2>
				<ul class="leftlist">
					<li><a href="http://www.kingdomofloathing.com">The Kingdom of Loathing</a></li>
					<li><a href="http://www.guildwars.com">Guild Wars</a></li>
					<li><a href="http://www.leagueoflegends.com">League of Legends</a></li>
				</ul>
		</div>
	</div>
-->
	<div class="top_blur"></div>
	<div class="main" id="main_screen">
		<!-- The location of all the information not included above -->
		<?php require("doodads/news.html"); ?>
	</div>
</body>
</html>	