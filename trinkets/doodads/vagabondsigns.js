/* 	Scripts for The Internet Vagabond
	www.theinternetvagabond.com
	By Bill "Azulien" Niblock
*/

//Main-Footer/Article-Header Information Array Functions
	var footer_x = 0;
	var footer_text = new Array("The Internet Vagabond &copy 2009-2012", "azulien@theinternetvagabond.com", "Optimized for Opera", "Built in Notepad++");
	function cycleArray(){
		footer_x+=1;
		if (footer_x > (footer_text.length - 1)){ footer_x = 0;}
		document.getElementById("vagabond_notice").innerHTML=footer_text[footer_x];
	}
		
//Main Header-Button Functions
	$(document).ready(function() {
		$(".navlink").click(function(){
			$("#main_screen").load("doodads/" + this.id + ".html", {}, 
				function(responseText, textStatus, XMLHttpRequest){
					if (textStatus==="error"){$("#bodystuff").load("doodads/wandering.php");}
			});
		$(".navat").removeClass("navat").addClass("navlink");
		$(this).removeClass("navlink").addClass("navat");
		});
	$("#news").removeClass("navlink").addClass("navat");
	});
	
//Pop-up boxes for Twitter/G+ feeds, links, and the change log
	function popupWindow(windowID){
		if (document.getElementById(windowID).style.display=="block"){
			document.getElementById(windowID).style.display="none";
			document.getElementById(windowID + "_button").style.backgroundColor="#CC9999";
			document.getElementById(windowID + "_button").style.color="#444444";}
		else {
			document.getElementById(windowID).style.display="block";
			document.getElementById(windowID + "_button").style.backgroundColor="#996666";
			document.getElementById(windowID + "_button").style.color="#CCCCCC";}
	}
	
/*jQuery Sub-header pop-up window function
	$(document).ready(function() {
		$(
		
*/