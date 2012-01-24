<?php
/**
 * Hand Class
 * 
 * This class represents one Player's Hand
 * 
 * @author Nikko Bautista <nikko@nikkobautista.com>
 * @version 1.0
 * @package Poker Demo
 */
class Hand
{
	/**
	 * constants to represent the Hand Types
	 */
	const ROYALFLUSH = 10;
	const STRAIGHTFLUSH = 9;
	const QUADS = 8;
	const FULLHOUSE = 7;
	const FLUSH = 6;
	const STRAIGHT = 5;
	const TRIPS = 4;
	const TWOPAIR = 3;
	const ONEPAIR = 2;
	const HIGHCARD = 1;
	
	/**
     * array of cards in the hand
	 *
     * @access private
     * @var array
     */
	private $_cards;
	
	/**
     * the numerical representation of the hand's type
	 *
     * @access private
     * @var integer
     */
	private $_hand_type;
	
	/**
     * array of cards that represent the best hand in the Hand
	 *
     * @access private
     * @var array
     */
	private $_best_hand;
	
	/**
     * the numerical score of the Hand
	 *
     * @access private
     * @var integer
     */
	private $_hand_score;
	
	
	/**
	 * Constructor instantiates a new Hand
	 *
	 * {@link $_cards}
	 */
	public function __construct()
	{
		$this->_cards = array();
	}
	
	/**
     * Return the total cards in the Hand
	 *
     * @return integer
     */
	public function getTotalCards()
	{
		return count($this->_cards);
	}
	
	/**
     * Returns the numerical score of the Hand
	 *
     * @return integer
     */
	public function getHandScore()
	{
		return $this->_hand_score;
	}
	
	/**
     * Adds a new card to the Hand
	 * Also sets the $_best_hand and calculates the $_hand_score 
	 * once the hand has reached 5 cards+
	 * Return $this for possible chaining
	 *
	 * {@link $_best_hand}
	 * {@link $_hand_score}
	 * @param Card $card
     * @return Hand
     */
	public function receiveCard(Card $card)
	{
		$this->_cards[] = $card;
		
		if( $this->getTotalCards() == 5 ) {
			$this->_best_hand = $this->_calculateBestHand();
			$this->_hand_score = $this->_calculateHandScore();
		}
		return $this;
	}
	
	/**
     * Calculate the Hand's numerical score
	 *
     * @return integer
     */
	private function _calculateHandScore()
	{
		$best_hand = $this->_best_hand;
		$total = 0;
		foreach($best_hand as $card) {
			$total += $card->getNumber();
		}
		return $total;
	}
	
	/**
     * Returns an array of Cards in the Hand
	 *
     * @return array
     */
	public function getCards()
	{
		return $this->_cards;
	}
	
	/**
     * Returns a "readable" version of the Hand's type
	 *
     * @return string
     */
	public function getReadableHandType()
	{
		switch($this->_hand_type) {
			case self::ROYALFLUSH:
				return 'Royal Flush';
				break;
			case self::STRAIGHTFLUSH:
				return 'Straight Flush';
				break;
			case self::QUADS:
				return 'Quads';
				break;
			case self::FULLHOUSE:
				return 'Full House';
				break;
			case self::FLUSH:
				return 'Flush';
				break;
			case self::STRAIGHT:
				return 'Straight';
				break;
			case self::TRIPS:
				return 'Trips';
				break;
			case self::TWOPAIR:
				return 'Two Pair';
				break;
			case self::ONEPAIR:
				return 'One Pair';
				break;
			case self::HIGHCARD:
			default:
				return 'High Card';
				break;
		}
	}
	
	/**
     * Return a numeric version of the Hand's type
	 *
     * @return integer
     */
	public function getHandType()
	{
		return $this->_hand_type;
	}
	
	/**
     * Return an array of Cards with the Hand's best combination of Cards
	 *
     * @return array
     */
	public function getBestHand()
	{
		return $this->_best_hand;
	}
	
	/**
     * Calculates the best possible combination from the Cards in the Hand and returns it
	 * Also sets the $_hand_type variable
	 *
	 * {@link $_hand_type}
     * @return array
     */
	private function _calculateBestHand()
	{	
		//Check for straight flush
		$straight_flush = $this->_getStraightFlush();
		if( !is_null($straight_flush) ) {
			$has_14 = false;
			$has_10 = false;
			//check if straight flush has A and 10
			foreach($straight_flush as $sf_card) {
				if( $sf_card->getNumber() == 14 ) {
					$has_14 = true;
				} else if( $sf_card->getNumber() == 10 ) {
					$has_10 = true;
				}
			}
			
			//if true for both, then it means we have a royal flush
			if( $has_14 == true && $has_10 == true ) {
				$this->_hand_type = self::ROYALFLUSH;
			} else {
				$this->_hand_type = self::STRAIGHTFLUSH;
			}
			return $straight_flush;
		}
		
		//Check for quads
		$quads = $this->_getQuads();
		if( !is_null($quads) ) {
			$this->_hand_type = self::QUADS;
			return $quads;
		}
		
		//Check for full house
		$fullhouse = $this->_getFullHouse();
		if( !is_null($fullhouse) ) {
			$this->_hand_type = self::FULLHOUSE;
			return $fullhouse;
		}
		
		//Check for flush
		$flush = $this->_getFlush();
		if( !is_null($flush) ) {
			$this->_hand_type = self::FLUSH;
			return $flush;
		}
		
		//Check for straight
		$straight = $this->_getStraight();
		if( !is_null($straight) ) {
			$this->_hand_type = self::STRAIGHT;
			return $straight;
		}
		
		//check for trips
		$trips = $this->_getTrips();
		if( !is_null($trips) ) {
			$this->_hand_type = self::TRIPS;
			return $trips;
		}
		
		//check for two pair
		$twopair = $this->_getTwoPair();
		if( !is_null($twopair) ) {
			$this->_hand_type = self::TWOPAIR;
			return $twopair;
		}
		
		//check for one pair
		$onepair = $this->_getOnePair();
		if( !is_null($onepair) ) {
			$this->_hand_type = self::ONEPAIR;
			return $onepair;
		}
		
		//check for high card
		$highcard = $this->_getHighCard();
		$this->_hand_type = self::HIGHCARD;
		return array($highcard);
	}
	
	/**
     * Checks if there is a straight flush in the Cards
	 *
     * @return array
     */
	private function _getStraightFlush()
	{
		$straight_flush = null;
		
		$has_flush = $this->_getFlush();
		$has_straight = $this->_getStraight();
		
		if( !is_null($has_flush) && !is_null($has_straight) ) {
			$straight_flush = $has_straight;
		}
		
		return $straight_flush;
	}
	
	/**
     * Checks if there are quads in the Cards
	 *
     * @return array
     */
	private function _getQuads()
	{
		$quads = null;
		
		$cards_by_number = $this->_sortCardsByNumber();
		
		foreach($cards_by_number as $cards_set) {
			if( count($cards_set) == 4 ) {
				$quads = $cards_set;
			}
		}
		
		return $quads;
	}
	
	/**
     * Checks if there is a full house the Cards
	 *
     * @return array
     */
	private function _getFullHouse()
	{
		$trips = null;
		$pair = null;
		
		$cards_by_number = $this->_sortCardsByNumber();
		
		foreach($cards_by_number as $cards_set) {
			if( count($cards_set) == 3 ) {
				$trips = $cards_set;
			} else if( count($cards_set) == 2 ) {
				$pair = $cards_set;
			}
		}
		
		if( is_null($trips) || is_null($pair) ) {
			return null;
		}
		
		return array_merge($trips, $pair);
	}
	
	/**
     * Checks if there is a flush in the Cards
	 *
     * @return array
     */
	private function _getFlush()
	{
		$flush = null;
		$cards_by_suit = $this->_sortCardsBySuit();
		
		foreach($cards_by_suit as $cards_set) {
			if( count($cards_set) == 5 ) {
				$flush = $cards_set;
				break;
			}
		}
		
		return $flush;
	}
	
	/**
     * Checks if there is a straight in the Cards
	 *
     * @return array
     */
	private function _getStraight()
	{
		$straight = null;
		
		//check first if there are trips or a one pair
		//if either one is not null, then it means we have either trips or a pair
		//and since we'll need 5 different cards to get a straight, we don't have one here
		$has_trips = $this->_getTrips();
		$has_pair = $this->_getOnePair();
		
		if( !is_null($has_trips) || !is_null($has_pair) ) {
			return null;
		}
		
		$card_numbers = $this->_getCardNumbers();
		
		//list down all possible straights
		$possible_straights = array(
			array(14,2,3,4,5),
			range(2,6),
			range(3,7),
			range(4,8),
			range(5,9),
			range(6,10),
			range(7,11),
			range(8,12),
			range(9,13),
			range(10,14)
		);
		
		//iterate through the possible straights and see if we have one that matches
		//our current card numbers
		foreach($possible_straights as $pstraights) {
			$difference = array_diff($card_numbers, $pstraights);
			if( count($difference) == 0 ) {
				$straight =  $this->_cards;
				break;
			}
		}
		
		return $straight;
	}
	
	/**
     * Checks if there are trips in the Cards
	 *
     * @return array
     */
	private function _getTrips()
	{
		$trips = null;
		$sorted_by_number = $this->_sortCardsByNumber();
		foreach($sorted_by_number as $number => $same_cards) {
			if( count($same_cards) == 3 ) {
				$trips = $same_cards;
				break;
			}
		}
		
		return $trips;
	}
	
	/**
     * Checks if there is a two pair in the Cards
	 *
     * @return array
     */
	private function _getTwoPair()
	{
		$best_twopair = array();
		$pairs = $this->_sortCardsByNumber();
		foreach($pairs as $number => $pair) {
			if( count($pair) == 2 ) {
				$best_twopair[] = $pair;
				if( count($best_twopair) == 2 ) {
					break;
				}
			}
		}
		
		if( count($best_twopair) < 2 ) {
			return null;
		} else {
			return array_merge($best_twopair[0], $best_twopair[1]);
		}
	}
	
	/**
     * Checks if there is a pair in the Cards
	 *
     * @return array
     */
	private function _getOnePair()
	{
		$bestpair = null;
		$pairs = $this->_sortCardsByNumber();
		foreach($pairs as $number => $pair) {
			if( count($pair) == 2 ) {
				$bestpair = $pair;
				break;
			}
		}
		
		return $bestpair;
	}
	
	/**
     * Gets the highest Card in the Hand
	 * based on their numeric values
	 *
     * @return array
     */
	private function _getHighCard()
	{
		$high_card = null;
		foreach($this->_cards as $card) {
			if( is_null($high_card) ) {
				$high_card = $card;
			} else if($card->getNumber() > $high_card->getNumber()) {
				$high_card = $card;
			}
		}
		return $high_card;
	}
	
	/**
     * Returns the numerical values of the Cards
	 * in the Hand
	 *
     * @return array
     */
	private function _getCardNumbers()
	{
		$card_numbers = array();
		foreach($this->_cards as $card) {
			$card_numbers[] = $card->getNumber();
		}
		
		return $card_numbers;
	}
	
	/**
     * Returns a two-dimensional array that sorts
	 * the cards by their suit
	 *
     * @return array
     */
	private function _sortCardsBySuit()
	{
		$cards_same_suits = array();
		foreach($this->_cards as $card) {
			$cards_same_suits[$card->getSuit()][] = $card;
		}
		
		ksort($cards_same_suits);
		return $cards_same_suits;
	}
	
	/**
     * Returns a two-dimensional array that sorts
	 * the cards by their number
	 *
     * @return array
     */
	private function _sortCardsByNumber()
	{
		$cards_same_numbers = array();
		foreach($this->_cards as $card) {
			$cards_same_numbers[$card->getNumber()][] = $card;
		}
		
		krsort($cards_same_numbers);
		return $cards_same_numbers;
	}
}