<?php
//include the files
include_once 'models/Card.php';
include_once 'models/Dealer.php';
include_once 'models/Deck.php';
include_once 'models/Hand.php';
include_once 'models/Player.php';

//get the player names from the form
$player_names = $_POST['players'];

//Create a new Dealer
$dealer = new Dealer();

//iterate through the player names
foreach($player_names as $num => $player_name) {
	$dealer->registerPlayer(new Player($player_name));
}

//tell the dealer to deal the cards to the players
$dealer->dealCards();

//ask the dealer the rankings of the players
$player_ranking = $dealer->determineWinnerRanking();

//variable for getting remaining cards
$cardcount = 52;
?>

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
					Winner winner chicken dinner!
				</h1>
			</div>
			
			<div class="row">
				<div class="span16">
					<?php //iterate through player rankings ?>
					<?php foreach($player_ranking as $rank => $player): ?>
					<div>
						<h2>
							#<?php echo $rank+1; ?> <?php echo $player->getName(); ?> - <?php echo $player->getReadableHandType(); ?> (<?php
								$implode_me = array();
								foreach($player->getBestHand() as $best_card) {
									$implode_me[] = "<span class=\"{$best_card->getColor()}\">{$best_card->getDisplayName()}</span>";
								}
								echo implode(', ', $implode_me);
							?>):
						</h2>
						<?php
						$cards = $player->getCards();
						$implode_me_again = array();
						foreach($cards as $card) {
							$implode_me_again[] = "<span class=\"{$card->getColor()}\">{$card->getDisplayName()}</span>";
							$cardcount--;
						}
						?>
						<h3>Cards: <?php echo implode(', ', $implode_me_again); ?></h3>
					</div>
					<hr />
					<?php endforeach; ?>
					<?php //display the remaining cards ?>
					<?php $deck = $dealer->getDeck(); ?>
					<div>
					<h2>Remaining Cards in Deck (<?php echo $cardcount; ?> left)</h2>
					<?php
					$implode_me_last = array();
					foreach($deck->getCards() as $card) {
						$implode_me_last[] = "<span class=\"{$card->getColor()}\">{$card->getDisplayName()}</span>";
						$cardcount--;
					}
					?>
					<h3>Cards: <?php echo implode(', ', $implode_me_last); ?></h3>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>