<?php

namespace BC\RawBlades;

use Illuminate\View\Factory;
use Illuminate\Events\Dispatcher;
use Illuminate\View\FileViewFinder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Compilers\BladeCompiler;

class Blade
{
    /**
     * Array of paths to Blade files.
     *
     * @var array
     */
    protected $viewPaths;

    /**
     * Path to compiled Blade files.
     *
     * @var string
     */
    protected $compiledPath;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var EngineResolver
     */
    protected $resolver;

    /**
     * @var Compiler
     */
    protected $compiler;

    /**
     * @var Factory
     */
    protected $view;

    /**
     * @param string|array $view_paths
     * @param string       $compiled_path
     * @param Dispatcher   $events
     */
    public function __construct($view_paths, string $compiled_path, Dispatcher $events = null)
    {
        $this->viewPaths    = (array) $view_paths;
        $this->compiledPath = $compiled_path;
        $this->events       = $events ?? new Dispatcher();

        $this->registerFilesystem()
            ->registerEngineResolver()
            ->registerViewFinder()
            ->registerFactory();
    }

    /**
     * Undefined methods are proxied to the compiler
     * and the view factory for API ease of use.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->compiler, $name)) {
            return $this->compiler->{$name}(...$arguments);
        }

        if (method_exists($this->view, $name)) {
            return $this->view->{$name}(...$arguments);
        }
    }

    protected function registerFilesystem()
    {
        $this->files = new Filesystem();

        return $this;
    }

    protected function registerEngineResolver()
    {
        $this->resolver = new EngineResolver();
        $this->registerPhpEngine($this->resolver);
        $this->registerBladeEngine($this->resolver);

        return $this;
    }

    protected function registerPhpEngine($resolver)
    {
        $this->resolver->register('php', function () {
            return new PhpEngine();
        });

        return $this;
    }

    protected function registerBladeEngine($resolver)
    {
        $this->compiler = new BladeCompiler($this->files, $this->compiledPath);

        $this->resolver->register('blade', function () {
            return new CompilerEngine($this->compiler, $this->files);
        });

        return $this;
    }

    protected function registerViewFinder()
    {
        $this->finder = new FileViewFinder($this->files, $this->viewPaths);

        return $this;
    }

    protected function registerFactory()
    {
        $this->view = new Factory($this->resolver, $this->finder, $this->events);

        return $this;
    }
}
