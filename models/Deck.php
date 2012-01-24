<?php
/**
 * Deck Class
 * 
 * This class represents one deck of cards in a poker game
 * 
 * @author Nikko Bautista <nikko@nikkobautista.com>
 * @version 1.0
 * @package Poker Demo
 */
 
 class Deck {
	
	/**
     * A cards private variable. Each Deck, 
	 * when instantiated will be instantiated
	 * with 52 Card objects and be put in
	 * this array
	 *
     * @access private
     * @var array
     */
	private $_cards;
	
	/**
	 * Constructor instantiates new Cards
	 *
	 * {@link $_cards}
	 */
	public function __construct()
	{
		$suits = array(
			Card::DIAMONDS,
			Card::HEARTS,
			Card::CLUBS,
			Card::SPADES
		);
		
		$numbers = range(2,14);
		
		foreach($suits as $suit) {
			foreach($numbers as $num) {
				$this->_cards[] = new Card($num, $suit);
			}
		}
	}
	
	/**
     * Shuffles the cards, takes in a multiplier 
	 * which can be used to seed the number of times
	 * the deck is shuffled
	 * Return $this for possible chaining
	 *
	 * @param integer $multiplier number of times the deck should be shuffled, defaults to 100
	 * @return Deck
     */
	public function shuffle($multiplier = 100)
	{
		for( $x = 0; $x < $multiplier; $x++ ) {
			shuffle($this->_cards);
		}
		return $this;
	}
	
	
	/**
     * Returns the remaining cards in the deck
	 *
	 * @return array
     */
	public function getCards()
	{
		return $this->_cards;
	}
	
	/**
     * Deals the top-most card on the deck
	 *
	 * @return Card
     */
	public function dealCard()
	{
		if( count($this->_cards) < 1 ) {
			throw new Exception('No more cards in the deck, sorry!');
		}
		
		return array_shift($this->_cards);
	}
}