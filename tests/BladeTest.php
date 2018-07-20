<?php

use BC\Blade\Blade;
use Illuminate\View\View;

class BladeTest extends PHPUnit\Framework\TestCase
{
    /**
     * Clear Blade's cache before each test.
     */
    public function setUp()
    {
        parent::setUp();

        foreach (glob(__DIR__ . '/cache/*.php') as $file) {
            unlink($file);
        }
    }

    /** @test */
    public function it_compiles()
    {
        $bar = 'Lorem ipsum dolor sit amet';

        $output = (new Blade(__DIR__ . '/views', __DIR__ . '/cache'))
            ->make('foo', compact('bar'))
            ->render();

        $this->assertContains($bar, $output);
    }
}
