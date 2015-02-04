/* 	Scripts for The Internet Vagabond
	www.theinternetvagabond.com
	By Bill "Azulien" Niblock
*/

// Main-Footer/Article-Header Information Array Functions
	// var footer_x = 0;
	// var footer_text = new Array("The Internet Vagabond &copy 2009-2012", "azulien@theinternetvagabond.com", "Optimized for Opera", "Built in Notepad++");
	// function cycleArray(){
		// footer_x+=1;
		// if (footer_x > (footer_text.length - 1)){ footer_x = 0;}
		// document.getElementById("vagabond_notice").innerHTML=footer_text[footer_x];
	// }
		
//Main Header-Button Functions
	$(document).ready(function() {
		$(".header_other_buttons_links_link").click(function(){
			$(".dyna_post").slideToggle('fast');
			$("." + this.id + "_cont").slideToggle('fast');
		});
	});
