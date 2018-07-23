<?php

namespace WebInvest;

class MySort {

    private $res;

    function __construct(array $arr)
    {
        $arrLinks = $this->bundingIndexesByLenghtOfWords($arr);
        $this->res = $this->sortingByIndexes($arrLinks);
    }

    function get() {
        return $this->res;
    }

    /**
     * Связывание массива ссылок с индекным массивом, по условию упорядочивания : длины слова и последним символом
     * @param array $array
     * @return array
     */
    private function bundingIndexesByLenghtOfWords(array &$array) : array {

        $arrayLinks = [];
        // вначале, банально по длине
        foreach ($array as &$val) {
            $key = mb_strlen($val, 'UTF-8');
            $indexLastChar = mb_substr($val, $key - 1, 1);
            // создание индекса для группировки по первому условию + последний симовол
            $arrayLinks[$key * 1000000 + $this->mb_ord($indexLastChar)] = $val;
        }
        return $arrayLinks;
    }

    /**
     * Простая сортировка полученных индексов, без использования sort
     * @param array $arrayLinks
     * @return array
     */
    private function sortingByIndexes(array &$arrayLinks) : array {

        $sortedIndexes = [];
        // нужен нормальный массив для того чтобы задать смещение для сортировки
        for ($index = 0; $index < count($arrayLinks); $index++) {
            $sortedIndexes[$index] = key($arrayLinks);
            next($arrayLinks);
        }

        for ($i = 0; $i < count($sortedIndexes) - 1; $i++) {
            for ($c = $i + 1; $c < count($sortedIndexes); $c++) {
                if ($sortedIndexes[$i] > $sortedIndexes[$c]) {
                    $self = $sortedIndexes[$i];
                    $sortedIndexes[$i] = $sortedIndexes[$c];
                    $sortedIndexes[$c] = $self;
                }
            }
        }

        $resultArray = [];
        foreach ($sortedIndexes as $key => $keyLinkedArray) {
            $resultArray[] = $arrayLinks[$keyLinkedArray];
        }

        return $resultArray;
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

