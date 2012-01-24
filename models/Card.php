<?php
/**
 * Card Class
 * 
 * This class represents one of card in a deck
 * 
 * @author Nikko Bautista <nikko@nikkobautista.com>
 * @version 1.0
 * @package Poker Demo
 */
 
 class Card {
 
	/**
	 * constants to represent the suits
	 */
	const DIAMONDS = 1;
	const HEARTS = 2;
	const CLUBS = 3;
	const SPADES = 4;
	
	/**
     * the numerical value of the card
	 *
     * @access private
     * @var integer
     */
	private $_number;
	
	/**
     * the suit of the card
	 *
     * @access private
     * @var integer
     */
	private $_suit;
	
	/**
	 * Constructor instantiates new Cards
	 *
	 * {@link $_number}
	 * {@link $_suit}
	 *
	 * @param integer $number the numerical representation of the number for the card
	 * @param integer $suit the numeric representation of the suit for the card
	 */
	public function __construct($number, $suit)
	{
		$this->_number = $number;
		$this->_suit = $suit;
	}
	
	/**
     * Returns a readable version of the number of the card
	 *
	 * @return string|integer
     */
	public function getReadableNumber()
	{
		switch($this->_number) {
			case 14:
				return 'Ace';
				break;
			case 13:
				return 'King';
				break;
			case 12:
				return 'Queen';
				break;
			case 11:
				return 'Jack';
				break;
			default:
				return $this->_number;
		}
	}
	
	/**
	 * Returns a displayable version of the number of the card
	 *
	 * @return string|integer
     */
	public function getDisplayNumber()
	{
		switch($this->_number) {
			case 14:
				return 'A';
				break;
			case 13:
				return 'K';
				break;
			case 12:
				return 'Q';
				break;
			case 11:
				return 'J';
				break;
			default:
				return $this->_number;
		}
	}
	
	/**
     * Returns a numeric version of the number of the card
	 *
	 * @return integer
     */
	public function getNumber()
	{
		return $this->_number;
	}
	
	/**
     * Returns a numeric version of the suit of the card
	 *
	 * @return integer
     */
	public function getSuit()
	{
		return $this->_suit;
	}
	
	 /**
     * Returns a readable version of the suit of the card
	 *
	 * @return string
     */
	public function getReadableSuit()
	{
		switch($this->_suit) {
			case self::DIAMONDS:
				return 'Diamonds';
				break;
			case self::HEARTS:
				return 'Hearts';
				break;
			case self::CLUBS:
				return 'Clubs';
				break;
			case self::SPADES:
				return 'Spades';
				break;
		}
	}
	
	 /**
	 * Returns a displayable version of the suit of the card
	 *
	 * @return string
     */
	public function getDisplaySuit()
	{
		switch($this->_suit) {
			case self::DIAMONDS:
				return '&diams;';
				break;
			case self::HEARTS:
				return '&hearts;';
				break;
			case self::CLUBS:
				return '&clubs;';
				break;
			case self::SPADES:
				return '&spades;';
				break;
		}
	}
	
	 /**
     * Returns the card's color, for display purposes
	 *
	 * @return string
     */
	public function getColor()
	{
		switch($this->_suit) {
			case self::DIAMONDS:
			case self::HEARTS:
				return 'red';
				break;
				
			case self::CLUBS:
			case self::SPADES:
			default:
				return 'black';
				break;
		}
	}
	
	 /**
     * Get the card's "readable" name
	 *
	 * @return string
     */
	public function getReadableName()
	{
		return "{$this->getReadableNumber()} of {$this->getReadableSuit()}";
	}
	
	
	 /**
     * Get the card's "displayable" name
	 * @return string
     */
	public function getDisplayName()
	{
		return "{$this->getDisplayNumber()}{$this->getDisplaySuit()}";
	}
}