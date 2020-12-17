<?php

use BC\Blade\Blade;

class BladeTest extends PHPUnit\Framework\TestCase
{
    /**
     * Clear Blade's cache before each test.
     */
    public function setUp() : void
    {
        parent::setUp();

        foreach (glob(__DIR__ . '/cache/*.php') as $file) {
            unlink($file);
        }
    }

    /** @test */
    public function it_compiles() : void
    {
        $output = (new Blade(__DIR__ . '/views', __DIR__ . '/cache'))
            ->make('foo')
            ->with(['bar' => $bar = 'Lorem ipsum dolor sit amet'])
            ->render();

        $this->assertStringContainsString($bar, $output);
    }
}
