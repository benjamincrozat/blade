<?php

use BC\Blade\Blade;

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
        $lorem = 'Lorem ipsum dolor sit amet';

        $blade = new Blade(__DIR__ . '/views', __DIR__ . '/cache');

        $blade->directive('lorem', function () use ($lorem) {
            return '<?= "' . $lorem . '"; ?>';
        });
        $blade->component('layout', 'layout');
        $blade->component('components.example', 'example');

        $output = $blade->make('pages.example')
            ->withName($name = 'Benjamin')
            ->render();

        $this->assertContains('<!DOCTYPE html>', $output);
        $this->assertContains("Hello $name!", $output);
        $this->assertContains('<section>', $output);
        $this->assertContains($lorem, $output);
        $this->assertContains('</section>', $output);
    }
}
