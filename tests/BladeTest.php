<?php

use BC\RawBlades\Blade;

class BladeTest extends PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_compiles()
    {
        $blade = new Blade(__DIR__ . '/views', __DIR__ . '/cache');

        $this->assertEquals('Hey-Diddly-Ho Homer!', trim($blade->make('flanders')->render()));
    }
}
