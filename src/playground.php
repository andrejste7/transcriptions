<?php

use Laracasts\Transcription\Transcription;

require 'vendor/autoload.php';

$path = __DIR__ . '/../test/stubs/basic-example.vtt';

$lines = Transcription::load($path)->lines();

foreach ($lines as $line) {
    var_dump($line->toAnchorTag());
}