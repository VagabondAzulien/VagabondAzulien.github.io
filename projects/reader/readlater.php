<DOCTYPE html>
<head>
 <?php $dbhandle = mysqli_connect("localhost", "billn", "fatty119", "internetvagabond"); ?>
 <style>
	.later{
		display: flex;
		display: -webkit-flex;
		flex-flow: column;
		-webkit-flex-flow: column;
		justify-content: center;
		min-width: 290px; 
		max-width: 290px; 
		border: 2px solid black;	
	}
	
	.later #title{
		font: italic 2.0em monospace;
		text-align: center;
		border: 2px solid grey;
	}

	.later #actions{
		display: flex;
		justify-content: center;
		padding: 5px 0px;
	}

	#actions #rl_add {
		border-top-left-radius: 5px;
		border-bottom-left-radius: 5px;
	}

	#actions #rl_srt {
		margin: 0px 5px;
	}

	#actions #rl_lst {
		border-top-right-radius: 5px;
		border-bottom-right-radius: 5px;
	}

	#actions div[id^="rl_"] {
		background-color: grey;
		cursor: pointer;
		min-width: 50px; max-width: 50px;
		min-height: 20px; max-height: 20px;
		text-align: center;
		padding: 5px 15px;
		box-shadow: 0px 1px 2px 1px black;
		transition: background-color .5s;
	}

	#actions div[id^="rl_"]:hover {
		background-color: #DCDCDC;
	}
	
	#actions div[id^="rl_"]:active {
		box-shadow: 0px 0px 5px 2px #555555 inset;
		background-color: white;
		color: black;
	}
	
	.readlist{
		padding: 0px 10px;	
	}

	.readlist #listtitle{
		font: italic 0.8em monospace;
	}

	.readlist #article {
		padding: 5px;
		margin: 10px 0px 20px 0px;
		border-bottom-right-radius: 15px; 
		background-color: #DCDCDC;
		box-shadow: 1px 1px 2px 2px #555555;
	}

	.readlist #a_date {
		float: left;
		font-size: 0.9em;
	}

	.readlist #a_opts {
		float: right;
	}

	.readlist #a_opts_list {

	}

	.readlist #a_opts_del {

	}

	.readlist #a_title {
		font: 1.1em bold;
	}

	.readlist #a_link {
		font-size: 0.75em;
		color: grey;
	}
 </style>
</head>

<body>
<section id="readlater" class="later">
 <header id="title">Read Later</header>
 <nav id="actions">
	<!-- refresh, add, others -->
	<div id="rl_add" onclick="addRL()">Add</div>
	<div id="rl_srt" onclick="srtRL()">Sort</div>
	<div id="rl_lst" onclick="lstRL()">Lists</div>
	<div style="clear:both"></div>
 </nav>
 <div id="readlist" class="readlist">
	<div id="listtitle">Default List</div>
        <?php if (mysqli_connect_errno($dbhandle)){ echo "Failed to connect: " . mysqli_connect_error();}
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
	       <div style="clear:both"></div>
	       <div id="a_title"><?php echo $entry['title'];?></div>
	       <div id="a_link"><?php echo $entry['url'];?></div>
       </div>
 <?php } ?>
	</div>
</section>
</body>
