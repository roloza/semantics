<?php


namespace App\Custom\Tools;


class ReadingTime
{
    /**
     * Calculate an approximate reading-time for a post.
     *
     * @param  string $content The content to be measured.
     * @return  integer Reading-time in seconds.
     */
    public static function readingTime($content) {

        // Predefined words-per-minute rate.
        $words_per_minute = 225;
        $words_per_second = $words_per_minute / 60;

        // Count the words in the content.
        $word_count = str_word_count( strip_tags( $content ) );

        // [UNUSED] How many minutes?
        $minutes = floor( $word_count / $words_per_minute );

        // [UNUSED] How many seconds (remainder)?
        $seconds_remainder = floor( $word_count % $words_per_minute / $words_per_second );

        // How many seconds (total)?
        $seconds_total = floor( $word_count / $words_per_second );

        return $seconds_total;
    }

    /**
     * PARSE TIME
     *
     * Convert seconds (int) into a nicely formatted string.
     *
     * @param  integer $seconds The number of seconds.
     * @return  string Formatted output.
     */
    public static function parseTime( $seconds ) {

        // String to store our output.
        $string_output = '';

        // Double-check we're using an integer.
        $seconds = (int) $seconds;

        // How many minutes?
        $minute_count = floor( $seconds / 60 );
        $minute_count = self::convertNumberToWords( $minute_count );

        // How many seconds?
        $minute_remainder = $seconds % 60;

        /**
         * Specific responses for a range
         * of times up to two minutes:
         */
        if ( $seconds < 30 ) {

            $string_output .= 'Lecture très rapide.';

        } elseif  ( $seconds < 50 ) {

            $string_output .= 'Moins d\'une minute.';

        } elseif  ( $seconds < 55 ) {

            $string_output .= 'Environ une minute.';

        } elseif  ( $seconds < 65 ) {

            $string_output .= 'Un peu plus d\'une minute';

        } elseif  ( $seconds < 85 ) {

            $string_output .= 'Une minute et quelques.';

        } elseif  ( $seconds < 95 ) {

            $string_output .= 'Environ une minute et demi';

        } elseif  ( $seconds < 120 ) {

            $string_output .= 'Un peu moins de deux minutes';

            /**
             * Dynamic responses for a variety
             * of times over two minutes:
             */
        } elseif ( $minute_remainder < 2 || $minute_remainder > 58 ) {

            // If we're within +/- 2 seconds of a minute:
            $string_output .= $minute_count . ' minutes, environ.';

        } elseif ( $minute_remainder > 50 ) {

            // If we're within less than 10 seconds short of any minute:
            $string_output .= 'Un peu moins de ' . $minute_count . ' minutes.';

        } elseif ( $minute_remainder < 10 ) {

            // If we're within less than 10 seconds over any minute:
            $string_output .= 'Un peu plus de ' . $minute_count . ' minutes.';

        } elseif ( $minute_remainder < 15 || $minute_remainder > 45 ) {

            // If we're within +/- 15 seconds of any minute:
            $string_output .= 'Environ ' . $minute_count . ' minutes.';

        } elseif ( $minute_remainder > 20 && $minute_remainder < 40 ) {

            // If we're within +/- 10 seconds of any half-minute:
            $string_output .= $minute_count . ' et demi.';

        } elseif ( $minute_remainder < 10 || $minute_remainder > 50 ) {
            $string_output .= $minute_count . ' minutes.';
        } else {
            $string_output .= 'Quelque chose comme ' . $minute_count . ' minutes.';
        }

        return $string_output;
    }

    /**
     * DISPLAY NUMBERS
     *
     * Convert numbers into human-readable words.
     *
     * Borrowed from:
     * http://www.karlrixon.co.uk/writing/convert-numbers-to-words-with-php/
     *
     * @param  integer $number Raw number.
     * @return string         Number as a word.
     */
    public static function convertNumberToWords($number) {

        $dictionary  = array(
            0   => 'zero',
            1   => 'un',
            2   => 'deux',
            3   => 'trois',
            4   => 'quatre',
            5   => 'cinq',
            6   => 'six',
            7   => 'sept',
            8   => 'huit',
            9   => 'neuf',
            10  => 'dix',
            11  => 'onze',
            12  => 'douze',
            13  => 'treize',
            14  => 'quatorze',
            15  => 'quinze',
            16  => 'seize',
            17  => 'dix-sept',
            18  => 'dix-huit',
            19  => 'dix-neuf',
            20  => 'vingt',
            30  => 'trente',
            40  => 'quarante',
            50  => 'cinquante',
            60  => 'soixante',
            70  => 'soixante-dix',
            80  => 'quatre-vingts',
            90  => 'quatre-vingts-dix',
            100 => 'cent'
        );

        $string = $dictionary[$number];

        return $string;
    }
}