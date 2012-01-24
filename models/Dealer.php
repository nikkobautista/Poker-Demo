<?php
/**
 * Dealer Class
 * 
 * This class represents a dealer in a poker game
 * 
 * @author Nikko Bautista <nikko@nikkobautista.com>
 * @version 1.0
 * @package Poker Demo
 */
 
class Dealer {
	/**
     * A deck private variable. Each Dealer, 
	 * when instantiated will have one (1) deck
	 *
     * @access private
     * @var Deck
     */
	private $_deck;
	
	/**
	 * An array of the players who are part of the game
	 *
	 *
	 * @access private
	 * @var array
	 */
	private $_players;
	
	/**
	 * Constructor sets up a new Deck instance
	 * Also shuffles the deck
	 *
	 * {@link $_deck}
	 */
	public function __construct()
	{
		$this->_deck = new Deck();
		$this->_deck->shuffle();
		$this->_players = array();
	}
	
	
	/**
     * Register a Player for the game
	 * Return $this for possible chaining
	 *
	 * @param Player $player
     * @return Dealer
     */
	public function registerPlayer(Player $player)
	{
		$this->_players[] = $player;
		return $this;
	}
	
	/**
     * Registers a list of Players for the game
	 * Return $this for possible chaining
	 *
	 * @param array $players
     * @return Dealer
     */
	public function registerPlayers($players)
	{
		foreach($players as $player) {
			$this->registerPlayer($player);
		}
		return $this;
	}
	
	/**
     * Return the Deck the Dealer is "holding"
	 *
     * @return Deck
     */
	public function getDeck()
	{
		return $this->_deck;
	}
	
	/**
     * Return true once all players have
	 * been dealt cards
	 * Return $this for possible chaining
	 *
     * @return Dealer
     */
	public function dealCards()
	{
		foreach($this->_players as $player) {
			if( $player->getHasBeenDealt() == false ) {
				while($player->getTotalCards() < 5) {
					$player->receiveCard($this->_deck->dealCard());
				}
				$player->setHasBeenDealt(true);
			}
		}
		return $this;
	}
	
	
	/**
     * Rank the registered players
	 * from best to worst based
	 * on their hands
	 *
     * @return array
     */
	public function determineWinnerRanking()
	{
		$player_ranking = array();
		foreach($this->_players as $player) {
			$player_rankings[$player->getHandType()][] = $player;
		}
		
		krsort($player_rankings);
		
		function sortByHandScore($a, $b) {
			if( $a->getHandScore() > $b->getHandScore() ) {
				return -1;
			} else if ($a->getHandScore() < $b->getHandScore() ) {
				return 1;
			} else {
				return 0;
			}
		}
		
		$final_ranking = array();
		foreach($player_rankings as $hand_type => $players_in_this_rank) {
			usort($players_in_this_rank, 'sortByHandScore');
			$final_ranking = array_merge($final_ranking, $players_in_this_rank);
		}
		
		return $final_ranking;
	}
}