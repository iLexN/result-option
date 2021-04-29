<?php
declare(strict_types=1);

namespace Ilex\PackageName\Tests\Option;

trait SimpleData
{

    public function data()
    {
        yield 'null' => [null];
        yield 'int' => [2];
        yield 'string' => ['hello'];
        yield 'object' => [new \stdClass()];
    }

    public function callFn2():int{
        return 2;
    }
}
