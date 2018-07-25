<?php

namespace WebInvest;

use function PHPSTORM_META\elementType;

class MySort {

    private $res;

    /**
     * MySort constructor.
     * @param array $arr
     * @param TypeSort $typeSort
     */
    function __construct(array $arr, TypeSort $typeSort)
    {
        $this->res = $this->sort($arr, $typeSort);
    }

    /**
     * @return string
     */
//    function __toString() : string {
//        if (!empty($res) && is_array($res)) return json_encode($res);
//        else new \ErrorException(sprintf("Invalid value %s for %s", $res, get_class($this)));
//    }


    /**
     * @return array
     */
    function get() : array {
        return $this->res;
    }

    /**
     * Сортировка : по длине, по символам с конца
     *
     * @param array $array
     * @param TypeSort $typeSort
     * @return array
     */
    private function sort(array $array, TypeSort $typeSort) : array {

        $arrayLinks = array();
        $len = $this->mb_ord("ы") - $this->mb_ord("а");
        $maxLen = ($typeSort == TypeSort::Desc) ? max(array_map('mb_strlen', $array)) : 0;

        // вначале, банально по длине
        foreach ($array as &$val) {
            $key = mb_strlen($val, 'UTF-8');
            $index = 0;
            for ($i = 1; $i <= mb_strlen($val); $i++) {
                $curIndex = $key - $i; // $key - $i; $i - 1, т.к от 0;
                $char = mb_substr($val, $curIndex, 1);
                // сдвиг по символам
                $index += (($typeSort == TypeSort::Desc) ?
                        ($this->mb_ord("а") - $this->mb_ord($char) + $len)
                        : ($this->mb_ord($char)) + $len) * ($curIndex + 1);
            }
            $index += (($typeSort == TypeSort::Desc) ? $maxLen - mb_strlen($val) : $key) * 1000000;
            // создание индекса для группировки по первому условию + последний симовол
            $arrayLinks[$index] = $val;
        }
        ksort($arrayLinks);
        return $arrayLinks;
    }


    /**
     * Получение значения символа по таблице, т.к в 7.1 подджержки ord 2 байта, нет
     * @param $string
     * @return int
     */
    private function mb_ord($string)
    {
        if (extension_loaded('mbstring') === true)
        {
            mb_language('Neutral');
            mb_internal_encoding('UTF-8');
            mb_detect_order(array('UTF-8', 'ISO-8859-15', 'ISO-8859-1', 'ASCII'));

            $result = unpack('N', mb_convert_encoding($string, 'UCS-4BE', 'UTF-8'));

            if (is_array($result) === true)
            {
                return $result[1];
            }
        }
        return ord($string);
    }

}

