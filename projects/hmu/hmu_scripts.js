/* 	Scripts for Hero Mash Up!
	www.theinternetvagabond.com
	By Bill "Azulien" Niblock
*/

//Button Functions
	$(document).ready(function() {
		$(".menu_item").click(function(){
			$("#main_area").load("" + this.id + ".php", 
				function(responseText, textStatus, XMLHttpRequest){
					if (textStatus==="error"){$("#main_area").load("hmu_error.php");}
			});
		$(".menu_item_selected").removeClass("menu_item_selected").addClass("menu_item");
		$(this).removeClass("menu_item").addClass("menu_item_selected");
		});
	$("#stories").removeClass("menu_item").addClass("menu_item_selected");
	});

//Current Fight Button Functions
	$(document).ready(function() {
		$(".current_team").click(function() {
			$("#main_area").load("teams.php",
				function(responseText, textStatus, XMLHttpRequest){
					if (textStatus==="error"){$("#main_area").load("hmu_error.php");}
					else{
						$(".info_popup").fadeIn("fast", function(){
							$(".info_popup_background").fadeTo("fast", 0.7, function(){
								$(".info_popup_foreground").fadeTo("fast", 1.3);
							});
						});
						$(".info_popup_close").click(function() {
							$(".info_popup").fadeOut("fast");
						});
					}
			});
			$(".menu_item_selected").removeClass("menu_item_selected").addClass("menu_item");
			$("#teams").removeClass("menu_item").addClass("menu_item_selected");
		});
		$("#current_arena").click(function(){
			$("#main_area").load("arenas.php",
				function(responseText, textStatus, XMLHttpRequest){
					if (textStatus==="error"){$("#main_area").load("hmu_error.php");}
			});
			$(".menu_item_selected").removeClass("menu_item_selected").addClass("menu_item");
			$("#arenas").removeClass("menu_item").addClass("menu_item_selected");
		});
	});