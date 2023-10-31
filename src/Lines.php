<?php

namespace Laracasts\Transcription;

class Lines extends Collection
{
    public function html(): string
    {
        return $this->map(fn (Line $line) => $line->toHtml())->__toString();
    }

    public function __toString(): string
    {
        return implode("\n", $this->items);
    }
}