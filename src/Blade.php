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
use Illuminate\Contracts\View\Factory as FactoryContract;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;

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
     * @var FileViewFinder
     */
    protected $finder;

    /**
     * @var Factory
     */
    protected $view;

    /**
     * @param string|array             $view_paths
     * @param string                   $compiled_path
     * @param DispatcherContract|null  $events
     * @param Filesystem|null          $files
     * @param EngineResolver|null      $resolver
     * @param ViewFinderInterface|null $finder
     * @param FactoryContract|null     $factory
     */
    public function __construct($view_paths, string $compiled_path, DispatcherContract $events = null, Filesystem $files = null, EngineResolver $resolver = null, ViewFinderInterface $finder = null, FactoryContract $factory = null)
    {
        $this->viewPaths    = (array) $view_paths;
        $this->compiledPath = $compiled_path;
        $this->events       = $events ?? new Dispatcher();

        $this->registerFilesystem($files)
            ->registerEngineResolver($resolver)
            ->registerViewFinder($finder)
            ->registerFactory($factory);
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

    protected function registerFilesystem(Filesystem $files = null)
    {
        $this->files = $files ?? new Filesystem();

        return $this;
    }

    protected function registerEngineResolver(EngineResolver $resolver = null)
    {
        $this->resolver = $resolver ?? new EngineResolver();

        return $this->registerPhpEngine($this->resolver)
            ->registerBladeEngine($this->resolver);
    }

    protected function registerPhpEngine()
    {
        $this->resolver->register('php', function () {
            return new PhpEngine();
        });

        return $this;
    }

    protected function registerBladeEngine()
    {
        $this->resolver->register('blade', function () {
            return new CompilerEngine(
                $this->compiler = new BladeCompiler($this->files, $this->compiledPath),
                $this->files
            );
        });

        return $this;
    }

    protected function registerViewFinder(ViewFinderInterface $finder = null)
    {
        $this->finder = $finder ?? new FileViewFinder($this->files, $this->viewPaths);

        return $this;
    }

    protected function registerFactory(FactoryContract $factory = null)
    {
        $this->view = $factory ?? new Factory($this->resolver, $this->finder, $this->events);

        return $this;
    }
}
