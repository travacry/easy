<?php
/**
 * Created by PhpStorm.
 * User: tr1o
 * Date: 23.07.2018
 * Time: 15:08
 */

use PHPUnit\Framework\TestCase;
use WebInvest\MyClass;

class MySortTest extends TestCase
{

    public function testSortingByLenghtOfWords()
    {
        $array = ['Улитка', 'Лебедь', 'Заяц', 'Волк', 'Кот', 'Сова'];
        $res = new \WebInvest\MySort($array);
        $this->assertArraySubset(['Кот','Сова','Волк','Заяц','Улитка','Лебедь'], $res);
    }
}
