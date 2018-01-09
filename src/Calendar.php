<?php
/**
 * Created by PhpStorm.
 * User: lorenzo adinolfi
 * Date: 08/01/2018
 * Time: 21:06
 */

namespace Calendar;

use DateTimeInterface;

class Calendar implements CalendarInterface
{

    /** @var \DateTimeImmutable */
    private $datetime;

    /**
     * @param DateTimeInterface $datetime
     */
    public function __construct(DateTimeInterface $datetime)
    {
        $this->datetime = new \DateTimeImmutable($datetime->format('Y-m-d'));
    }

    /**
     * Get the day
     *
     * @return int
     */
    public function getDay()
    {
        return intval($this->datetime->format('d'));
    }

    /**
     * Get the weekday (1-7, 1 = Monday)
     *
     * @return int
     */
    public function getWeekDay()
    {
        return intval($this->datetime->format('N'));
    }

    /**
     * Get the first weekday of this month (1-7, 1 = Monday)
     *
     * @return int
     */
    public function getFirstWeekDay()
    {
        $firstDay = new \DateTime($this->datetime->format('01-m-Y'));
        return intval($firstDay->format('N'));
    }

    /**
     * Get the first week of this month (18th March => 9 because March starts on week 9)
     *
     * @return int
     */
    public function getFirstWeek()
    {
        $firstWeekDay = new \DateTime($this->datetime->format('01-m-Y'));
        return intval($firstWeekDay->format('W'));
    }

    /**
     * Get the number of days in this month
     *
     * @return int
     */
    public function getNumberOfDaysInThisMonth()
    {
        return intval($this->datetime->format('t'));
    }

    /**
     * Get the number of days in the previous month
     *
     * @return int
     */
    public function getNumberOfDaysInPreviousMonth()
    {
        $previousMonth = $this->datetime->modify('last day of previous month');
        return intval($previousMonth->format('t'));
    }

    /**
     * Get the calendar array
     *
     * @return array
     */
    public function getCalendar()
    {
        $result = array();

        //first day of month
        $dayOfMonth = new \DateTimeImmutable($this->datetime->format('Y-m-01'));

        //the week to highlist
        $weekToHighlight = intval($this->datetime->sub(new \DateInterval('P1W'))->format('W'));

        $numberOfWeeksInMonth = $this->getNumberOfWeekInThisMonth();

        //caculate the number of days in the weeks to fill the resulting array
        $lastDayOfYear = new \DateTime($this->datetime->format('Y-12-31'));
        $numberOfWeeksInYear = $lastDayOfYear->format('W');
        $weekNumber = intval($dayOfMonth->format('W'));

        //first day of the week (could not be the first of the month)
        $week = new \DateTime();

        if ($weekNumber > $numberOfWeeksInYear) { //in case the year does not start with Monday
            $week->setISODate(intval($this->datetime->sub(new \DateInterval('P1Y'))->format('Y')), $weekNumber);
        } else {
            $week->setISODate(intval($this->datetime->format('Y')), $weekNumber);
        }

        $i=0;
        do {
            if ($i > 0) {
                $week->add(new \DateInterval('P1D'));
                $weekNumber = intval($week->format('W'));
            }

            if ($weekNumber == $weekToHighlight) {
                $result[$weekNumber][intval($week->format('d'))] = true;
            } else {
                $result[$weekNumber][intval($week->format('d'))] = false;
            }

            $i++;
        } while ($i < 7*$numberOfWeeksInMonth); //every week has 7 days...

        return $result;
    }

    private function getNumberOfWeekInThisMonth()
    {
        // Start of month
        $start = new \DateTime($this->datetime->format('Y-m-01'));
        // End of month
        $end = new \DateTime($this->datetime->format('Y-m-t'));
        // Start week
        $start_week = intval($start->format('W'));
        // End week
        $end_week = intval($end->format('W'));

        if ($end_week < $start_week) { // weeks wraps between year
            return ((52 + $end_week) - $start_week) + 2;
        }

        return ($end_week - $start_week) + 1;
    }
}
