/*	+++++++++++++++++++++++++++++++++++++++++++++
	|	JS for gcgen.theinternetvagabond.com	|
	|	By Bill "VagabondAzulien" Niblock		|
	|	Copyright 2012 TheInternetVagabond		|
	+++++++++++++++++++++++++++++++++++++++++++++

	Utility Scripts
*/
	$(document).ready(function() {
		$("#option1").click(function(){
			$("#generation1").slideDown('fast', function(){
				$("#option2").addClass("notTHEchoice");});
		});
		$("#option2").click(function(){
			$("#generation2").slideDown('fast', function(){
				$("#option1").addClass("notTHEchoice");});
		});
		$("#option_help").click(function(){
			$("#gen_help").slideToggle('fast');
		});
		$("#clsDD").change(function(){
			$("#showHPArea").html(rollChar_showHP());
		});
		$("#showHPArea").html(rollChar_showHP());
	});

/*	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	|	A generator for quickly making characters for Bill Adcock's Green City setting.		|
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

Step 1: Decide upon the generation procedure.
	
	Option 1 is to roll 3d6 in order six times for your stats and then choose a class.
	Option 2 is to roll 3d6 six times, then roll a d6 to randomly determine your class, then arrange your stats to fit your class.
		
	The classes (and their d6-associated value)
		1 - Dwarf
		2 - Cleric
		3 - Fighter
		4 - Magic-User
		5 - Specialist
		6 - Elf

Step 2: Roll Stats

	Roll 3d6 for each of six attributes 
	
		The attributes
			[STR]ength
			[DEX]terity
			[CON]stitution
			[INT]elligence
			[WIS]dom
			[CHA]risma
			
Step 3: Hit Points
				
	Hit points are max per class.
		
		Class Hitpoints:
				Dwarf - d10	
			   Cleric - d6
			  Fighter - d8
		   Magic-User - d4
		   Specialist - d6
				  Elf - d6
		
Step 4: Starting Wealth

	Roll 3d6, multiply by 10. Very straight forward
 

Step 5: Random Bonus Items
	Roll a d3, choose from the list that many items. The items can repeat, unless otherwise noted (specialty cases can be developed).
	CODE: The following in an array: 
			An extra pair of warm wool socks.
			A pretty good hand axe, made for chopping wood.
			A jar of pickled eggs.
			A small cask (approx. 1 gallon) of mead.
			A small bag of assorted animals' teeth.  
			A set of ten scrolls, each bearing a series of lascivious illustrations.  The set is entitled "Valkyries Gone Wild."
			A vest with pockets on the inside.
			A walrus tusk inscribed with a prayer to Odin.
			A pound of salt.
			An ostentatious hat.
			Beans! Maybe they're magic.
			A set of sheeps' knuckles, carved and marked as dice.
			A lucky rabbits' foot.
			A waterproof sack.
			A ball of string.  It won't support the weight of anything larger than a cat.
			A pound of wax.
			A hammer and chisel.
			A half-dozen torches.
			An iron kettle.
			It's a puppy!
*/ 

var classHP = 0;

function rollChar_stat(){
	return (((Math.floor(Math.random()*6))+1) + ((Math.floor(Math.random()*6))+1) + ((Math.floor(Math.random()*6))+1));
}

function rollChar_Class(){
	classHP = (Math.floor(Math.random()*6));
	var classText = new Array("Dwarf", "Cleric", "Fighter", "Magic-User", "Specialist", "Elf");
	return "You have chosen to live life as a daring " + classText[classHP] + ".";
}

function rollChar_HP(){
	var hitPoints = new Array("10", "6", "8", "4", "6", "6");
	return hitPoints[classHP];
}

function rollChar_showHP(){
	return $("#clsDD").val();
}

function rollChar_wealth(){
	return ((((Math.floor(Math.random()*6))+1) + ((Math.floor(Math.random()*6))+1) + ((Math.floor(Math.random()*6))+1)) * 10);
}

function rollChar_BItems(){
	var goodiesRoll = Math.floor(Math.random()*3) + 1;
	var goodiesText = "Your bountiful pack also contains...<br />";
	var randBItems = new Array("An extra pair of warm wool socks.", "A pretty good hand axe, made for chopping wood.", "A jar of pickled eggs.", "A small cask (approx. 1 gallon) of mead.",
							  "A small bag of assorted animals\' teeth.", "A set of ten scrolls, each bearing a series of lascivious illustrations. The set is entitled \"Valkyries Gone Wild.\"",
							  "A vest with pockets on the inside.", "A walrus tusk inscribed with a prayer to Odin.", "A pound of salt.", "An ostentatious hat.", "Beans! Maybe they\'re magic.",
							  "A set of sheeps\' knuckles, carved and marked as dice.", "A lucky rabbit\'s foot.", "A waterproof sack.", "A ball of string. It won\'t support the weight of anything larger than a cat.",
							  "A pound of wax.", "A hammer and chisel.", "A half-dozen torches.", "An iron kettle.", "It\'s a puppy!");
	
	for (i=0; i < goodiesRoll; i++){
		goodiesText += "<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp... " + randBItems[(Math.floor(Math.random()*20))];
	}
	
	return goodiesText;
}
