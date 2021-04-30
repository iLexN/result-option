<?php
declare(strict_types=1);

namespace Ilex\PackageName\Result;

use Ilex\PackageName\Error\ResultException;
use Ilex\PackageName\Option\Option;

/**
 * @template T
 * @template T3
 */
class Result
{

    /**
     * @param T $value
     */
    private function __construct(
        private mixed $value,
        private bool $ok,
    ) {
    }

    /**
     * @template T2
     * @param T2 $value
     */
    public static function makeOk(mixed $value): self
    {
        return new self($value, true);
    }

    public static function makeErr(\Throwable $throwable): self
    {
        return new self($throwable, false);
    }

    public function isOk(): bool
    {
        return $this->ok;
    }

    public function isErr(): bool
    {
        return !$this->ok;
    }

    public function ok(): Option
    {
        if ($this->isOk()) {
            return Option::some($this->value);
        }
        return Option::none();
    }

    public function err(): Option
    {
        if ($this->isOk()) {
            return Option::none();
        }
        return Option::some($this->value);
    }

    //    public function and(mixed $value){
    //
    //    }

    //    public function andThen(){
    //
    //    }
    //
    //    public function or(){
    //
    //    }

    //    public function orElse(){}
    /**
     * @param T3 $value
     *
     * @return T|T3
     */
    public function unwrap_or(mixed $value)
    {
        if ($this->isOk()){
            return $this->value;
        }
        return $value;
    }
    //    public function unwrap_or_else{}

    /**
     * @return T
     * @throws \Ilex\PackageName\Error\ResultException
     */
    public function expect(string $message): mixed
    {
        if ($this->isOk()) {
            return $this->value;
        }

        if ($this->value instanceof \Throwable) {
            throw ResultException::customMessage($message, $this->value);
        }
        throw ResultException::ShouldNotHappen();
    }

    /**
     * @return T
     * @throws \Ilex\PackageName\Error\ResultException
     */
    public function unwrap(): mixed
    {
        if ($this->isOk()) {
            return $this->value;
        }

        if ($this->value instanceof \Throwable) {
            throw ResultException::unwrap($this->value);
        }

        throw ResultException::ShouldNotHappen();
    }

    /**
     * @param string $message
     *
     * @return T
     * @throws \Ilex\PackageName\Error\ResultException
     */
    public function expectErr(string $message)
    {
        if ($this->isOk()) {
            throw ResultException::customMessage($message);
        }
        return $this->value;
    }

    /**
     * @return T
     * @throws \Ilex\PackageName\Error\ResultException
     */
    public function unwrap_err(): \Throwable
    {
        if ($this->isOk()) {
            throw ResultException::unwrapErr();
        }
        return $this->value;
    }

    //    public function transpose()
    //    {
    //    }
    //
    //    public function flatten()
    //    {
    //    }


}
