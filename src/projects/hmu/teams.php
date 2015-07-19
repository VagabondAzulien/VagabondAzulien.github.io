<!--
	Team Page for HERO MASH UP!
-->

<!--Team-Popup Functions -->
	<script type="text/javascript">
		$(document).ready(function() {
			$(".team_cont").click(function() {
				$(".info_popup").fadeIn("fast", function(){
					$(".info_popup_background").fadeTo("fast", 0.7, function(){
						$(".info_popup_foreground").fadeTo("fast", 1.3);
					});
				});
			});
			$(".info_popup_close").click(function() {
				$(".info_popup").fadeOut("fast");
			});
		});
	</script>

<!-- Information Pop-Up -->
	<div class="info_popup">
		<div class="info_popup_background"></div>
		<div class="info_popup_foreground">
			<div class="info_popup_close">CLOSE</div>
			<div class="info_popup_detail">This is a test of the awesome info pop-up box!</div>
		</div>
	</div>

<!-- Team Box Template
<div class="team_cont">
	<div class="team_pic"></div>
	<div class="team_syn">
		<div class="team_title"></div>
		<div class="team_about"></div>
	</div>
</div>
-->

<div class="teams">
	<div class="team_cont" id="team1">
		<div class="team_pic" id="team1"></div>
		<div class="team_syn">
			<div class="team_title" id="team1">Super Cool Team Name</div><br />
			<div class="team_about" id="team1">This super cool team is composed of super cool people, who do super cool stuff. They are some super cool dudes.</div>
		</div>
	</div>

	<div class="team_cont">
		<div class="team_pic"></div>
		<div class="team_syn">
			<div class="team_title">Cool Guy</div><br />
			<div class="team_about">Really, it's a cool story, bro.</div>
		</div>
	</div>

	<div class="team_cont">
		<div class="team_pic"></div>
		<div class="team_syn">
			<div class="team_title"></div><br />
			<div class="team_about"></div>
		</div>
	</div>

	<div class="team_cont">
		<div class="team_pic"></div>
		<div class="team_syn">
			<div class="team_title"></div><br />
			<div class="team_about"></div>
		</div>
	</div>

	<div class="team_cont">
		<div class="team_pic"></div>
		<div class="team_syn">
			<div class="team_title"></div><br />
			<div class="team_about"></div>
		</div>
	</div>

	<div class="team_cont">
		<div class="team_pic"></div>
		<div class="team_syn">
			<div class="team_title"></div><br />
			<div class="team_about"></div>
		</div>
	</div>

	<div class="team_cont">
		<div class="team_pic"></div>
		<div class="team_syn">
			<div class="team_title"></div><br />
			<div class="team_about"></div>
		</div>
	</div>

	<div class="team_cont">
		<div class="team_pic"></div>
		<div class="team_syn">
			<div class="team_title"></div><br />
			<div class="team_about"></div>
		</div>
	</div>

	<div class="team_cont">
		<div class="team_pic"></div>
		<div class="team_syn">
			<div class="team_title"></div><br />
			<div class="team_about"></div>
		</div>
	</div>

	<div class="team_cont">
		<div class="team_pic"></div>
		<div class="team_syn">
			<div class="team_title"></div><br />
			<div class="team_about"></div>
		</div>
	</div>
</div>