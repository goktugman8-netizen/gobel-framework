<?php

namespace Gobel\View;

use Exception;

class View
{
    /**
     * The compiler instance.
     *
     * @var Compiler
     */
    protected $compiler;

    /**
     * The directory where compiled views are stored.
     *
     * @var string
     */
    protected $cachePath;

    /**
     * The directory where views are located.
     *
     * @var string
     */
    protected $viewPath;
    
    /**
     * Data shared across all views.
     *
     * @var array
     */
    protected $shared = [];

    /**
     * Sections content.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * Sections stack for nested sections.
     *
     * @var array
     */
    protected $sectionStack = [];

    /**
     * Create a new view instance.
     *
     * @param string $viewPath
     * @param string $cachePath
     */
    public function __construct(string $viewPath, string $cachePath)
    {
        $this->viewPath = rtrim($viewPath, '/\\');
        $this->cachePath = rtrim($cachePath, '/\\');
        $this->compiler = new Compiler();

        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0755, true);
        }
    }

    /**
     * Make a view instance and render it.
     *
     * @param string $view
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function make(string $view, array $data = [])
    {
        $path = $this->findViewPath($view);
        
        $compiledPath = $this->getCompiledPath($path);

        // Compile if the compiled file doesn't exist or if the template was modified
        if (!file_exists($compiledPath) || filemtime($path) > filemtime($compiledPath)) {
            $contents = file_get_contents($path);
            $compiled = $this->compiler->compileString($contents);
            file_put_contents($compiledPath, $compiled);
        }

        return $this->evaluatePath($compiledPath, array_merge($this->shared, $data));
    }

    /**
     * Evaluate the compiled path to extract the final rendered string.
     *
     * @param string $__path
     * @param array $__data
     * @return string
     */
    protected function evaluatePath($__path, $__data)
    {
        $__env = $this;

        extract($__data, EXTR_SKIP);

        ob_start();

        try {
            include $__path;
        } catch (Exception $e) {
            ob_end_clean();
            throw $e;
        } catch (\Throwable $e) {
            ob_end_clean();
            throw new Exception($e->getMessage(), (int) $e->getCode(), $e);
        }

        return ob_get_clean();
    }

    /**
     * Find the path to a view by name.
     *
     * @param string $view
     * @return string
     * @throws Exception
     */
    protected function findViewPath(string $view)
    {
        $view = str_replace('.', DIRECTORY_SEPARATOR, $view);

        $path = $this->viewPath . DIRECTORY_SEPARATOR . $view . '.gobel.php';

        if (file_exists($path)) {
            return $path;
        }

        $path = $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';

        if (file_exists($path)) {
            return $path;
        }

        throw new Exception("View [{$view}] not found.");
    }

    /**
     * Get the compiled path for a given view path.
     *
     * @param string $path
     * @return string
     */
    protected function getCompiledPath(string $path)
    {
        return $this->cachePath . DIRECTORY_SEPARATOR . sha1($path) . '.php';
    }

    /**
     * Start injecting content into a section.
     *
     * @param string $section
     * @return void
     */
    public function startSection(string $section)
    {
        if (ob_start()) {
            $this->sectionStack[] = $section;
        }
    }

    /**
     * Stop injecting content into a section.
     *
     * @return string
     * @throws Exception
     */
    public function stopSection()
    {
        if (empty($this->sectionStack)) {
            throw new Exception('Cannot end a section without first starting one.');
        }

        $last = array_pop($this->sectionStack);

        $this->sections[$last] = ob_get_clean();

        return $last;
    }

    /**
     * Yield the content for a given section.
     *
     * @param string $section
     * @param string $default
     * @return string
     */
    public function yieldContent(string $section, string $default = '')
    {
        return $this->sections[$section] ?? $default;
    }

    /**
     * Share data with all views.
     *
     * @param string|array $key
     * @param mixed $value
     * @return void
     */
    public function share($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $k => $v) {
            $this->shared[$k] = $v;
        }
    }
}
