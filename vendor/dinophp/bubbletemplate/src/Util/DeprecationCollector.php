<?php



namespace Bubble\Util;

use Bubble\Environment;
use Bubble\Error\SyntaxError;
use Bubble\Source;


final class DeprecationCollector
{
    private $bubble;

    public function __construct(Environment $bubble)
    {
        $this->bubble = $bubble;
    }

    /**
     * Returns deprecations for templates contained in a directory.
     *
     * @param string $dir A directory where templates are stored
     * @param string $ext Limit the loaded templates by extension
     *
     * @return array An array of deprecations
     */
    public function collectDir(string $dir, string $ext = '.bubble'): array
    {
        $iterator = new \RegexIterator(
            new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir), \RecursiveIteratorIterator::LEAVES_ONLY
            ), '{'.preg_quote($ext).'$}'
        );

        return $this->collect(new TemplateDirIterator($iterator));
    }

    /**
     * Returns deprecations for passed templates.
     *
     * @param \Traversable $iterator An iterator of templates (where keys are template names and values the contents of the template)
     *
     * @return array An array of deprecations
     */
    public function collect(\Traversable $iterator): array
    {
        $deprecations = [];
        set_error_handler(function ($type, $msg) use (&$deprecations) {
            if (\E_USER_DEPRECATED === $type) {
                $deprecations[] = $msg;
            }
        });

        foreach ($iterator as $name => $contents) {
            try {
                $this->bubble->parse($this->bubble->tokenize(new Source($contents, $name)));
            } catch (SyntaxError $e) {
                // ignore templates containing syntax errors
            }
        }

        restore_error_handler();

        return $deprecations;
    }
}
