<?php

namespace Gobel\View;

class Compiler
{
    /**
     * The regular expression to match GoBlade directives.
     *
     * @var string
     */
    protected $directivePattern = '/\B@(@?\w+(?:::\w+)?)([ \t]*)(\( (?: [^()]* | (?3) )* \))?/x';

    /**
     * Compile the given template contents.
     *
     * @param string $value
     * @return string
     */
    public function compileString($value)
    {
        $result = $this->compileEchoes($value);
        $result = $this->compileDirectives($result);

        return $result;
    }

    /**
     * Compile Blade echos into valid PHP.
     *
     * @param string $value
     * @return string
     */
    protected function compileEchoes($value)
    {
        // Unescaped echoes {!! !!}
        $value = preg_replace('/\{\!\!\s*(.+?)\s*\!\!\}/s', '<?php echo $1; ?>', $value);

        // Escaped echoes {{ }}
        $value = preg_replace('/\{\{\s*(.+?)\s*\}\}/s', '<?php echo htmlspecialchars($1 ?? \'\', ENT_QUOTES, \'UTF-8\'); ?>', $value);

        return $value;
    }

    /**
     * Compile Blade directives.
     *
     * @param string $value
     * @return string
     */
    protected function compileDirectives($value)
    {
        return preg_replace_callback($this->directivePattern, function ($matches) {
            $directive = $matches[1];
            $args = isset($matches[3]) ? $matches[3] : '';

            if (method_exists($this, $method = 'compile' . ucfirst($directive))) {
                return $this->$method($args);
            }

            return $matches[0];
        }, $value);
    }

    /**
     * Compile the if statements.
     *
     * @param string $expression
     * @return string
     */
    protected function compileIf($expression)
    {
        return "<?php if{$expression}: ?>";
    }

    /**
     * Compile the else-if statements.
     *
     * @param string $expression
     * @return string
     */
    protected function compileElseif($expression)
    {
        return "<?php elseif{$expression}: ?>";
    }

    /**
     * Compile the else statements.
     *
     * @param string $expression
     * @return string
     */
    protected function compileElse($expression)
    {
        return "<?php else: ?>";
    }

    /**
     * Compile the end-if statements.
     *
     * @param string $expression
     * @return string
     */
    protected function compileEndif($expression)
    {
        return "<?php endif; ?>";
    }

    /**
     * Compile the foreach statements.
     *
     * @param string $expression
     * @return string
     */
    protected function compileForeach($expression)
    {
        return "<?php foreach{$expression}: ?>";
    }

    /**
     * Compile the end-foreach statements.
     *
     * @param string $expression
     * @return string
     */
    protected function compileEndforeach($expression)
    {
        return "<?php endforeach; ?>";
    }

    /**
     * Compile the extends statements.
     *
     * @param string $expression
     * @return string
     */
    protected function compileExtends($expression)
    {
        $expression = trim($expression, '()\'" ');
        return "<?php echo \$__env->make('{$expression}', \get_defined_vars()); ?>";
    }

    /**
     * Compile the yield directive.
     *
     * @param string $expression
     * @return string
     */
    protected function compileYield($expression)
    {
        return "<?php echo \$__env->yieldContent{$expression}; ?>";
    }

    /**
     * Compile the section directive.
     *
     * @param string $expression
     * @return string
     */
    protected function compileSection($expression)
    {
        return "<?php \$__env->startSection{$expression}; ?>";
    }

    /**
     * Compile the endsection directive.
     *
     * @param string $expression
     * @return string
     */
    protected function compileEndsection($expression)
    {
        return "<?php \$__env->stopSection(); ?>";
    }
}
