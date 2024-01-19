<?php

namespace App\Utils;

class Converter
{
    //METODO RESPONS. POR CONVERTER UM NUM. DECIMAL. P/ BINARIO
    public static function getDecBin($decimal) 
    {
        return str_pad(decbin($decimal), 8, '0', STR_PAD_LEFT);
    }

    public static function getBinDec($binary) 
    {
        return bindec($binary);
    }

    public static function getCharBin($char) 
    {
        $asc = ord($char);
        return self::getDecBin($asc);
    }

    public static function getBinChar($binary)
    {
        $asc = self::getDecBin($binary);
        return chr($asc);
    }
}