<?php

declare(strict_types=1);

namespace Ilex\PackageName;

final class General
{

    /**
     * @param string $string
     */
    private function __construct(
        private string $string,
    ) {
    }

    public function get(): string
    {
        return $this->string;
    }

    public static function create(string $string): self
    {
        return new self($string);
    }
}
