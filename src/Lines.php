<?php

namespace Laracasts\Transcription;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

class Lines implements Countable, IteratorAggregate, ArrayAccess, JsonSerializable
{
    public function __construct(protected array $lines)
    {
        //
    }

    public function html(): string
    {
        $htmlLines = array_map(
            fn (Line $line) => $line->toAnchorTag(),
            $this->lines);

        return (new static($htmlLines))->__toString();
    }

    public function count(): int
    {
        return count($this->lines);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->lines);
    }

    public function __toString(): string
    {
        return implode("\n", $this->lines);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->lines[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->lines[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->lines[] = $value;
        } else {
            $this->lines[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->lines[$offset]);
    }

    public function jsonSerialize()
    {
        return $this->lines;
    }
}