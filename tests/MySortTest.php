<?php

use PHPUnit\Framework\TestCase;
use WebInvest\MySort;
use WebInvest\TypeSort;

class MySortTest extends TestCase
{

    public function testSortingByLenghtOfWordsAsc()
    {
        $comp = ['Кот', 'Сова', 'Волк', 'Заяц', 'Улитка', 'Лебедь'];
        $in = ['Улитка', 'Лебедь', 'Заяц', 'Волк', 'Кот', 'Сова'];


        try {
            $mySort = new MySort($in, new TypeSort(TypeSort::Asc));
            $result = $mySort->get();
            $this->assertEquals(count($result), count($comp));

            for ($i = 0; $i < count($comp); $i++) {
                $this->assertEquals(current($comp), current($result));
                if ($i != 0) {
                    next($comp);
                    next($result);
                }
            }

        } catch (ReflectionException $e) {
        }
    }

    public function testSortingByLenghtOfWordsDesc()
    {
        $comp = ['Лебедь', 'Улитка', 'Заяц', 'Волк', 'Сова', 'Кот'];
        $in = ['Улитка', 'Лебедь', 'Заяц', 'Волк', 'Кот', 'Сова'];

        try {
            $mySort = new MySort($in, new TypeSort(TypeSort::Desc));
            $result = $mySort->get();
            $this->assertEquals(count($result), count($comp));

            for ($i = 0; $i < count($comp); $i++) {
                $this->assertEquals(current($comp), current($result));
                if ($i != 0) {
                    next($comp);
                    next($result);
                }
            }

        } catch (ReflectionException $e) {
        }
    }
}
