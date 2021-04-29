<?php
declare(strict_types=1);

namespace Ilex\PackageName\Option;

use Ilex\PackageName\Error\OptionException;

/**
 * @template T
 * @template T2
 */
final class Option
{

    /**
     * @param T $value
     */
    private function __construct(
        private bool $isSome,
        private mixed $value,
    ) {
    }

    /**
     * @template T3
     * @param T3 $value
     */
    public static function some(mixed $value): self
    {
        return new self(true, $value);
    }

    public static function none(): self
    {
        return new self(false, null);
    }

    public static function default(): self
    {
        return self::none();
    }

    /**
     * @template T3
     * @param T3 $value
     */
    public static function from(mixed $value): self
    {
        return self::some($value);
    }

    public function isSome(): bool
    {
        return $this->isSome;
    }

    public function isNone(): bool
    {
        return !$this->isSome();
    }

    /**
     * @param T2|T $value
     */
    public function contains(mixed $value): bool
    {
        if ($this->isNone()) {
            return false;
        }
        return $value === $this->value;
    }

    /**
     * @return T
     * @throws \Ilex\PackageName\Error\OptionException
     */
    public function expect(string $message): mixed
    {
        if ($this->isSome()) {
            return $this->value;
        }
        throw OptionException::customMessage($message);
    }

    /**
     * @return T
     * @throws \Ilex\PackageName\Error\OptionException
     */
    public function unwrap(): mixed
    {
        if ($this->isSome()) {
            return $this->value;
        }
        throw OptionException::unwrap();
    }

    /**
     * @param T2 $value
     *
     * @return T|T2
     */
    public function unwrapOr(mixed $value): mixed
    {
        if ($this->isSome()) {
            return $this->value;
        }
        return $value;
    }

    /**
     * @return T|mixed
     */
    public function unwrapOrElse(callable $callable): mixed
    {
        if ($this->isSome()) {
            return $this->value;
        }
        return $callable();
    }

    //    public function okOr(mixed $value)
    //    {
    //        //todo
    //    }
    //
    //    public function okOrElse(callable $callable)
    //    {
    //        //todo
    //    }

    public function and(self $option): Option
    {
        if ($this->isSome()) {
            return $option;
        }
        return self::none();
    }


    /**
     * @param callable(T):Option $callable
     *
     * @return \Ilex\PackageName\Option\Option
     */
    public function andThen(callable $callable): Option
    {
        if ($this->isNone()) {
            return $this;
        }

        return $callable($this->value);
    }


    /**
     * @param callable(T):bool $callable
     *
     * @return \Ilex\PackageName\Option\Option
     */
    public function filter(callable $callable): Option
    {
        if ($this->isNone()) {
            return $this;
        }

        if ($callable($this->value)) {
            return $this;
        }

        return self::none();
    }
    //
    //    public function or(self $option)
    //    {
    //
    //    }
    //
    //    public function orElse(self $option)
    //    {
    //
    //    }
    //
    //    public function xor(self $option)
    //    {
    //
    //    }
    //
    //    public function take()
    //    {
    //
    //    }
    //

    /**
     * @param T $value
     */
    public function replace(mixed $value): Option
    {
        if ($this->isSome) {
            $old = self::some($this->value);
        } else {
            $old = self::none();
        }

        $this->toSome($value);
        return $old;
    }

    /**
     * @param T $value
     */
    private function toSome(mixed $value): void
    {
        $this->value = $value;
        $this->isSome = true;
    }

    //    public function transpose(){
    //
    //
    //    }

    public function flatten(): self
    {
        if ($this->isNone()) {
            return $this;
        }

        if ($this->value instanceof self) {
            return $this->value;
        }
        throw OptionException::flattenError();
    }
}
