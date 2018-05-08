<?php

use BC\RawBlades\Blade;

class BladeTest extends PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_compiles()
    {
        $lorem_ipsum = 'Lorem ipsum dolor sit amet';

        $blade = new Blade(__DIR__ . '/views', __DIR__ . '/cache');
        $blade->directive('loremIpsum', function () use ($lorem_ipsum) {
            return '<?= "' . $lorem_ipsum . '"; ?>';
        });
        $blade->component('layout', 'layout');
        $blade->component('components.example', 'example');
        $output = $blade->make('pages.example')->render();

        $this->assertContains($lorem_ipsum, $output);
        $this->assertContains('<section>', $output);
        $this->assertContains('</section>', $output);
    }
}
