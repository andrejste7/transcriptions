<?php

namespace Laracasts\Transcription;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

class Lines implements Countable, IteratorAggregate
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
}