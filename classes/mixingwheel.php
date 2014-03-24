<?php

class MixingWheel {

    private static $sharp_flat_keys = array(
        'C' => '8B',
        'G' => '9B',
        'D' => '10B',
        'A' => '11B',
        'E' => '12B',
        'B' => '1B',
        'F#' => '2B',
        'Gb' => '2B',
        'C#' => '3B',
        'Db' => '3B',
        'G#' => '4B',
        'Ab' => '4B',
        'D#' => '5B',
        'Eb' => '5B',
        'A#' => '6B',
        'Bb' => '6B',
        'F' => '7B',
        'Am' => '8A',
        'Em' => '9A',
        'Bm' => '10A',
        'F#m' => '11A',
        'Gbm' => '11A',
        'C#m' => '12A',
        'Dbm' => '12A',
        'G#m' => '1A',
        'Abm' => '1A',
        'D#m' => '2A',
        'Ebm' => '2A',
        'A#m' => '3A',
        'Bbm' => '3A',
        'Fm' => '4A',
        'Cm' => '5A',
        'Gm' => '6A',
        'Dm' => '7A'
    );

    public static function nearby_keys($key)
    {

        // split apart key
        $key_length = strlen($key);
        $key_middle = $key_length - 1;
        $key_number = (int)substr($key, 0, $key_middle);
        $key_letter = substr($key, $key_middle, 1);
        // original is always valid
        $harmonic_keys = array($key);

        // apply wheel circular movement
        if ($key_number == 1)
        {
            $harmonic_keys[] = 12 . $key_letter;
            $harmonic_keys[] = 2 . $key_letter;
        }
        elseif ($key_number == 12)
        {
            $harmonic_keys[] = 11 . $key_letter;
            $harmonic_keys[] = 1 . $key_letter;
        }
        else
        {
            $harmonic_keys[] = ($key_number - 1) . $key_letter;
            $harmonic_keys[] = ($key_number + 1) . $key_letter;
        }

        // apply wheel inner/outer movement
        if ($key_letter == 'A')
            $harmonic_keys[] = $key_number . 'B';
        else
            $harmonic_keys[] = $key_number . 'A';

        // success, return
        return $harmonic_keys;

    }

    public static function get_key($str)
    {

        $matches = array();
        // get mixing while matches
        if (preg_match('/(^[0-9]{1,2})([AB]{1})/', $str, $matches))
        {
            // verify the first match is less than 12
            if ((int)$matches[0] > 12)
                return null;
            // success
            return $str;
        }

        // get all valid sharp flats
        $sharp_flats = array_keys(self::$sharp_flat_keys);
        // see if it is a sharp flat instead
        if (array_search($str, $sharp_flats) === false)
            return null;
        // success
        return $sharp_flats[$str];

    }

}