<?php

namespace app\helpers;

/**
 * DateTime helpers provides some functionality regarding date and time
 */
class DateTime
{
    /**
     * Returns duration between two dates
     *
     * @param string $date1 in Y/m/d format
     * @param string $date2 in Y/m/d format
     * @param \DateTimeZone|string $date1Timezone
     * @param \DateTimeZone|string $date2Timezone
     * @return \DateInterval
     */
    public static function getDuration($date1, $date2, $date1Timezone = null, $date2Timezone = null)
    {
        if (!empty($date1Timezone)) {
            if (is_string($date1Timezone)) {
                $date1Timezone = new \DateTimeZone($date1Timezone);
            }
        }

        if (!empty($date2Timezone)) {
            if (is_string($date2Timezone)) {
                $date2Timezone = new \DateTimeZone($date2Timezone);
            }
        }

        $date1 = new \DateTime($date1, $date1Timezone);
        $date2 = new \DateTime($date2, $date2Timezone);

        return $date1->diff($date2);
    }

}