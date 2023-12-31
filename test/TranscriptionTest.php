<?php

namespace Laracasts\test;

use Laracasts\Transcription\Line;
use Laracasts\Transcription\Lines;
use Laracasts\Transcription\Transcription;
use PHPUnit\Framework\TestCase;

class TranscriptionTest extends TestCase
{
    protected Transcription $transcription;

    protected function setUp(): void
    {
        $this->transcription = Transcription::load(__DIR__ . '/stubs/basic-example.vtt');
    }

    /** @test */
    public function it_loads_a_vtt_file()
    {
        $this->assertStringContainsString('Here is a', $this->transcription);
        $this->assertStringContainsString(
            'example of a VTT file.',
            $this->transcription
        );
    }

    /** @test */
    public function it_can_convert_to_an_array_of_line_objects()
    {
        $lines = $this->transcription->lines();

        $this->assertCount(2, $lines);

        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
    }

    /** @test */
    public function it_discards_irrelevant_lines_from_the_vtt_file()
    {
        $this->assertStringNotContainsString('WEBVTT', $this->transcription);
        $this->assertCount(2, $this->transcription->lines());
    }

    /** @test */
    public function it_renders_the_lines_as_html()
    {
        $expected = <<<EOT
<a href="?time=00:03">Here is a</a>
<a href="?time=00:04">example of a VTT file.</a>
EOT;

        $result = $this->transcription->lines()->html();

        $this->assertEquals(
            trim(preg_replace('/\R+/', '', $expected)),
            trim(preg_replace('/\R+/', '', $result))
        );
    }

    /** @test */
    public function it_implements_array_access_interface()
    {
        $lines = $this->transcription->lines();

        $this->assertInstanceOf(\ArrayAccess::class, $lines);
        $this->assertInstanceOf(Lines::class, $lines);
        $this->assertInstanceOf(\Countable::class, $lines);
        $this->assertInstanceOf(\IteratorAggregate::class, $lines);
    }

    /** @test */
    public function it_can_render_as_json()
    {
        $lines = $this->transcription->lines();

        $this->assertInstanceOf(\JsonSerializable::class, $lines);
        $this->assertJson(json_encode($lines));
    }
}