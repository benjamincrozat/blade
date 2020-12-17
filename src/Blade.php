<?php

namespace BC\Blade;

use Illuminate\View\Factory;
use Illuminate\Events\Dispatcher;
use Illuminate\View\FileViewFinder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\ViewFinderInterface;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Compilers\CompilerInterface;
use Illuminate\Contracts\View\Factory as FactoryContract;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;

/**
 * @method \Illuminate\Contracts\View\View make($view, $data = [], $mergeData = [])
 * @method \Illuminate\Contracts\View\View with($key, $value = null)
 */
class Blade
{
    protected array $viewPaths;

    protected string $compiledPath;

    protected DispatcherContract $events;

    protected Filesystem $files;

    protected EngineResolver $resolver;

    protected CompilerInterface $bladeCompiler;

    protected FileViewFinder $finder;

    protected Factory $view;

    /**
     * @param string|array $view_paths
     */
    public function __construct($view_paths, string $compiled_path, DispatcherContract $events = null, ?ViewFinderInterface $finder = null, FactoryContract $factory = null)
    {
        $this->viewPaths    = (array) $view_paths;
        $this->compiledPath = (string) $compiled_path;
        $this->events       = $events ?: new Dispatcher();

        $this->registerFilesystem()
            ->registerEngineResolver()
            ->registerViewFinder($finder)
            ->registerFactory($factory);
    }

    /**
     * Undefined methods are proxied to the compiler
     * and the view factory for API ease of use.
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if (method_exists($this->bladeCompiler, $name)) {
            return $this->bladeCompiler->{$name}(...$arguments);
        }

        if (method_exists($this->view, $name)) {
            return $this->view->{$name}(...$arguments);
        }
    }

    protected function registerFilesystem() : self
    {
        $this->files = new Filesystem();

        return $this;
    }

    protected function registerEngineResolver() : self
    {
        $this->resolver = new EngineResolver();

        return $this->registerPhpEngine()
            ->registerBladeEngine();
    }

    protected function registerPhpEngine() : self
    {
        $this->resolver->register('php', function () {
            return new PhpEngine();
        });

        return $this;
    }

    protected function registerBladeEngine() : self
    {
        $this->bladeCompiler = new BladeCompiler($this->files, $this->compiledPath);

        $this->resolver->register('blade', function () {
            return new CompilerEngine($this->bladeCompiler, $this->files);
        });

        return $this;
    }

    protected function registerViewFinder(?ViewFinderInterface $finder = null) : self
    {
        $this->finder = $finder ?: new FileViewFinder($this->files, $this->viewPaths);

        return $this;
    }

    protected function registerFactory(?FactoryContract $factory = null) : self
    {
        $this->view = $factory ?: new Factory($this->resolver, $this->finder, $this->events);

        return $this;
    }
}
