<?php

namespace App\Helpers;

class Helper
{
    public static function dateToBD($date, $default = null)
    {
        $valida = preg_match('/\d{2}\/\d{2}\/\d{4}/', $date, $aux);

        if (!$valida) {
            return $date;
        }

        list($d, $m, $a) = explode('/', $aux[0]);

        $valida = checkdate($m, $d, $a);

        if (!$valida) {
            return $default;
        }

        return sprintf('%d-%s-%s', $a, $m, $d);
    }
}
