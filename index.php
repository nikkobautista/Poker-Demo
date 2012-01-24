<!DOCTYPE html>
<html>
<head>
	<title>Poker Demo</title>
	<link rel="stylesheet" href="css/reset.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
	<script src="js/jquery.min.js"></script>
	<style>
	body {
		padding-top: 40px;
		background-color: #EEEEEE;
	}
	
	.red {
		color: #FF0000;
	}
	
	.black {
		color: #000000;
	}
	
	.page-header {
		background-color: #F5F5F5;
		margin: -20px -20px 20px;
		padding: 20px 20px 10px;
		text-align: left;
	}
	
	.content {
		background-color: #FFFFFF;
		border-radius: 0 0 6px 6px;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
		margin: 0 -20px;
		padding: 20px;
	}
	#players_container {
		margin-top: 20px;
	}
	
	.player_form {
		margin-bottom: 10px;
	}
	</style>
	<script>
	
	function setPlayers(num) {
		var counter = 0;
		var insert_html = '';
		while( counter < num ){
			insert_html += '<div class="player_form">'+
			'Player Name #' + (counter+1) + ': <input placeholder="Player ' + (counter+1) + '\'s name" type="text" name="players[]" />'+
			'</div>';;
			counter++;
		}
		
		$('#players_forms').html(insert_html);
	}
	
	$(document).ready(function() {
		setPlayers(2);
		
		$('#num_players').change(function() {
			setPlayers($(this).val());
		});
	});
	
	</script>
</head>
<body>
	<div class="topbar">
		<div class="fill">
		<div class="container">
			<a class="brand" href="index.php">Poker Demo</a>
		</div>
		</div>
	</div>
	
	<div id="main" class="container">
		<div class="content">
			<div class="page-header">
				<h1>
					Enter Players here!
				</h1>
			</div>
			
			<div class="row">
				<div class="span16">
					<form method="post" action="play.php">
						<div>
							Number of Players:
							<select name="num_players" id="num_players">
								<?php foreach(range(2,6) as $num): ?>
								<option value="<?php echo $num; ?>"><?php echo $num; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<div id="players_container">
						<p>Player Names (optional):</p>
							<div id="players_forms">
							</div>
						</div>
						
						<div>
							<input type="submit" class="btn primary" value="Play!" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>