/* 	The un-Official Shakespeare Insult Generator
	Written by Bill "Vagabond Azulien" Niblock
	Source Material from reddit (and Shakespeare... duh...)
	http://www.theinternetvagabond.com
*/

/*	The function is rather straight forward: upon being called,
	it generates a random number for each array, and inputs the
	corrosponding value.
*/

// Insult arrays
	var first = new Array("artless", "bawdy", "beslubbering", "bootless", "churlish", "cockered", "clouted", "craven", "currish", "dankish", "dissembling", "droning", "errant", "fawning", "fobbing", "froward", "frothy", "gleeking", "goatish", "gorbellied", "impertinent", "infectious", "jarring", "loggerheaded", "lumpish", "mammering", "mangled", "mewling", "paunchy", "pribbling", "puking", "puny", "qualling", "rank", "reeky", "roguish", "ruttish", "saucy", "spleeny", "spongy", "surly", "tottering", "unmuzzled", "vain", "venomed", "villainous", "warped", "wayward", "weedy", "yeasty");
	var secnd = new Array("base-court", "bat-fowling", "beef-witted", "beetle-headed", "boil-brained", "clapper-clawed", "clay-brained", "common-kissing", "crook-pated", "dismal-dreaming", "dizzy-eyed", "doghearted", "dread-bolted", "earth-vexing", "elf-skinned", "fat-kidneyed", "fen-sucked", "flap-mouthed", "fly-bitten", "folly-fallen", "fool-born", "full-gorged", "guts-griping", "half-faced", "hasty-witted", "hedge-born", "hell-hated", "idle-headed", "ill-breeding", "ill-nurtured", "knotty-pated", "milk-livered", "motley-minded", "onion-eyed", "plume-plucked", "pottle-deep", "pox-marked", "reeling-ripe", "rough-hewn", "rude-growing", "rump-fed", "shard-borne", "sheep-biting", "spur-galled", "swag-bellied", "tardy-gaited", "tickle-brained", "toad-spotted", "unchin-snouted", "weather-bitten");
	var third = new Array("apple-john", "baggage", "barnacle", "bladder", "boar-pig", "bugbear", "bum-bailey", "canker-blossom", "clack-dish", "clotpole", "coxcomb", "codpiece", "death-token", "dewberry", "flap-dragon", "flax-wench", "flirt-gill", "foot-licker", "fustilarian", "giglet", "gudgeon", "haggard", "harpy", "hedge-pig", "horn-beast", "hugger-mugger", "joithead", "lewdster", "lout", "maggot-pie", "malt-worm", "mammet", "measle", "minnow", "miscreant", "moldwarp", "mumble-news", "nut-hook", "pigeon-egg", "pignut", "puttock", "pumpion", "ratsbane", "scut", "skainsmate", "strumpet", "varlot", "vassal", "whey-face", "wagtail");

// Main Function
	function poeticBurn(){
		makeTheShakespeareInsultWindow();
	}
	
	function makeTheShakespeareInsultWindow(){
		var mtsiw = document.createElement('div');
		mtsiw.style.position = "fixed"; mtsiw.style.top = "10px"; mtsiw.style.left = "10px";
		mtsiw.style.height = "100px";
		mtsiw.style.width = "200px";
		mtsiw.style.backgroundColor = "black";
		mtsiw.style.color = "white";
		mtsiw.innerHTML = "Thou " + first[Math.floor(Math.random()*first.length)] +
						  " " 	  + secnd[Math.floor(Math.random()*secnd.length)] +
						  " "	  + third[Math.floor(Math.random()*third.length)] + "!";
		document.body.appendChild(mtsiw);
	}