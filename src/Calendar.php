<?php
/**
 * Created by PhpStorm.
 * User: lorenzo adinolfi
 * Date: 08/01/2018
 * Time: 21:06
 */

namespace Calendar;


use DateTimeInterface;

class Calendar implements CalendarInterface {

	/** @var \DateTime */
	private $datetime;

	/**
	 * @param DateTimeInterface $datetime
	 */
	public function __construct( DateTimeInterface $datetime ) {
		$this->datetime = $datetime;
	}

	/**
	 * Get the day
	 *
	 * @return int
	 */
	public function getDay() {
		return intval($this->datetime->format('d'));
	}

	/**
	 * Get the weekday (1-7, 1 = Monday)
	 *
	 * @return int
	 */
	public function getWeekDay() {
		return intval($this->datetime->format('N'));
	}

	/**
	 * Get the first weekday of this month (1-7, 1 = Monday)
	 *
	 * @return int
	 */
	public function getFirstWeekDay() {
		$firstDay = new \DateTime($this->datetime->format('01-m-Y'));
		return intval($firstDay->format('N'));
	}

	/**
	 * Get the first week of this month (18th March => 9 because March starts on week 9)
	 *
	 * @return int
	 */
	public function getFirstWeek() {
		$firstWeekDay = new \DateTime($this->datetime->format('01-m-Y'));
		return intval($firstWeekDay->format('W'));
	}

	/**
	 * Get the number of days in this month
	 *
	 * @return int
	 */
	public function getNumberOfDaysInThisMonth() {
		return $this->datetime->format('t');
	}

	/**
	 * Get the number of days in the previous month
	 *
	 * @return int
	 */
	public function getNumberOfDaysInPreviousMonth() {
		$previousMonth = $this->datetime->sub(new \DateInterval('P1M'));
		return $previousMonth->format('t');
	}

	/**
	 * Get the calendar array
	 *
	 * @return array
	 */
	public function getCalendar() {

		$result = array();

		$oneWeekBefore = $this->datetime->sub(new \DateInterval('P1W'));
		$previousWeek = intval($oneWeekBefore->format('W'));

		for($i=$previousWeek; $i < $previousWeek + 7; $i++){

			//$result[$i][]
		}

		return $result;
	}
}