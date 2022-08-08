<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {

    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::CODING_STYLE,
        SetList::PHP_80,
        SetList::PHP_81,
        SetList::PSR_4,
        SetList::EARLY_RETURN,
        SetList::NAMING,
    ]);

    $rectorConfig->skip([
        Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector::class,
        Rector\Php80\Rector\FunctionLike\UnionTypesRector::class,
    ]);

//    $parameters->set(Option::SKIP, [
//        Rector\Php80\Rector\FunctionLike\UnionTypesRector::class,
//        Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector::class,
//        Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector::class,
//    ]);
};
