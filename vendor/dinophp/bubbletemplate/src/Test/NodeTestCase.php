<?php



namespace Bubble\Test;

use PHPUnit\Framework\TestCase;
use Bubble\Compiler;
use Bubble\Environment;
use Bubble\Loader\ArrayLoader;
use Bubble\Node\Node;

abstract class NodeTestCase extends TestCase
{
    abstract public function getTests();

    /**
     * @dataProvider getTests
     */
    public function testCompile($node, $source, $environment = null, $isPattern = false)
    {
        $this->assertNodeCompilation($source, $node, $environment, $isPattern);
    }

    public function assertNodeCompilation($source, Node $node, Environment $environment = null, $isPattern = false)
    {
        $compiler = $this->getCompiler($environment);
        $compiler->compile($node);

        if ($isPattern) {
            $this->assertStringMatchesFormat($source, trim($compiler->getSource()));
        } else {
            $this->assertEquals($source, trim($compiler->getSource()));
        }
    }

    protected function getCompiler(Environment $environment = null)
    {
        return new Compiler(null === $environment ? $this->getEnvironment() : $environment);
    }

    protected function getEnvironment()
    {
        return new Environment(new ArrayLoader([]));
    }

    protected function getVariableGetter($name, $line = false)
    {
        $line = $line > 0 ? "// line $line\n" : '';

        return sprintf('%s($context["%s"] ?? null)', $line, $name);
    }

    protected function getAttributeGetter()
    {
        return 'bubble_get_attribute($this->env, $this->source, ';
    }
}
