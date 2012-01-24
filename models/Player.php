<?php
/**
 * Player Class
 * 
 * This class represents one player in the game
 * 
 * @author Nikko Bautista <nikko@nikkobautista.com>
 * @version 1.0
 * @package Poker Demo
 */
class Player
{
	/**
     * the Player's Hand object
	 *
     * @access private
     * @var Hand
     */
	private $_hand;
	
	/**
     * this is to be set to true once the player has been dealt a hand with 5 cards
	 * should be false otherwise
	 *
     * @access private
     * @var boolean
     */
	private $_has_been_dealt;
	
	/**
     * the name of the player
	 *
     * @access private
     * @var string
     */
	private $_name;
	
	/**
	 * Constructor instantiates a new Player
	 *
	 * {@link $_name}
	 * {@link $_hand}
	 * {@link $_has_been_dealt}
	 *
	 * @param string $name the name of the player, if not provided, will randomly generate one
	 */
	public function __construct($name = null)
	{
		if( !is_null($name) && $name != '' ) {
			$this->_name = $name;
		} else {
			$this->_name = 'Player #' .rand();
		}
		
		$this->_hand = new Hand();
		$this->_has_been_dealt = false;
	}
	
	/**
     * Returns the player's name
	 *
     * @return string
     */
	public function getName()
	{
		return $this->_name;
	}
	
	/**
     * Returns true of the player has been dealt a hand with 5 cards
	 * false otherwise
	 *
     * @return boolean
     */
	public function getHasBeenDealt()
	{
		return $this->_has_been_dealt;
	}
	
	/**
     * Set the $_has_been_dealt variable
	 * Return $this for possible chaining
	 *
	 * @param boolean $status
     * @return Player
     */
	public function setHasBeenDealt($status)
	{
		if( $status === true ) {
			$this->_has_been_dealt = true;
		} else {
			$this->_has_been_dealt = false;
		}
		
		return $this;
	}
	
	/**
     * Returns the number of cards the hand has
	 *
     * @return integer
     */
	public function getTotalCards()
	{
		return $this->_hand->getTotalCards();
	}
	
	/**
     * Player receives a Card object
	 * Return $this for possible chaining
	 *
	 * @param Card $card
     * @return Player
     */
	public function receiveCard(Card $card)
	{
		$this->_hand->receiveCard($card);
		return $this;
	}
	
	/**
     * Return an array of the Player's Cards from his Hand
	 *
     * @return array
     */
	public function getCards()
	{
		return $this->_hand->getCards();
	}
	
	
	/**
     * Discard the current Hand of the user
	 * Return the Hand for possible chaining
	 *
     * @return Hand
     */
	public function newHand()
	{
		$this->_hand = new Hand();
		return $this->_hand;
	}
	
	
	/**
     * Return a numerical representation of the player's hand type. Hand types defined in the Hand class
	 * @see Hand
	 *
     * @return integer
     */
	public function getHandType()
	{
		return $this->_hand->getHandType();
	}
	
	/**
     * Return a readable representation of the player's hand
	 *
     * @return string
     */
	public function getReadableHandType()
	{
		return $this->_hand->getReadableHandType();
	}
	
	/**
     * Return an array of Cards of best combination of Cards from the Player's Hand
	 *
     * @return array
     */
	public function getBestHand()
	{
		return $this->_hand->getBestHand();
	}
	
	/**
     * Return the player's Hand score, used to calculate the ranking
	 *
     * @return integer
     */
	public function getHandScore()
	{
		return $this->_hand->getHandScore();
	}
}