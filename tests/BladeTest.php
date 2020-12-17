<?php

use BC\Blade\Blade;

class BladeTest extends PHPUnit\Framework\TestCase
{
    protected Blade $blade;

    /**
     * Clear Blade's cache before each test.
     */
    public function setUp() : void
    {
        parent::setUp();

        foreach (glob(__DIR__ . '/cache/*.php') as $file) {
            unlink($file);
        }

        $this->blade = new Blade(__DIR__ . '/views', __DIR__ . '/cache');
    }

    /** @test */
    public function it_compiles() : void
    {
        $output = $this
            ->blade
            ->make('foo')
            ->with(['bar' => $bar = 'Lorem ipsum dolor sit amet'])
            ->render()
        ;

        $this->assertStringContainsString($bar, $output);
    }
}
