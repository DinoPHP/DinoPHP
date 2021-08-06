<?php



namespace Bubble\Test;

use PHPUnit\Framework\TestCase;
use Bubble\Environment;
use Bubble\Error\Error;
use Bubble\Extension\ExtensionInterface;
use Bubble\Loader\ArrayLoader;
use Bubble\RuntimeLoader\RuntimeLoaderInterface;
use Bubble\BubbleFilter;
use Bubble\BubbleFunction;
use Bubble\BubbleTest;

/**
 * Integration test helper.
*
 * @author Karma Dordrak <drak@zikula.org>
 */
abstract class IntegrationTestCase extends TestCase
{
    /**
     * @return string
     */
    abstract protected function getFixturesDir();

    /**
     * @return RuntimeLoaderInterface[]
     */
    protected function getRuntimeLoaders()
    {
        return [];
    }

    /**
     * @return ExtensionInterface[]
     */
    protected function getExtensions()
    {
        return [];
    }

    /**
     * @return BubbleFilter[]
     */
    protected function getBubbleFilters()
    {
        return [];
    }

    /**
     * @return BubbleFunction[]
     */
    protected function getBubbleFunctions()
    {
        return [];
    }

    /**
     * @return BubbleTest[]
     */
    protected function getBubbleTests()
    {
        return [];
    }

    /**
     * @dataProvider getTests
     */
    public function testIntegration($file, $message, $condition, $templates, $exception, $outputs, $deprecation = '')
    {
        $this->doIntegrationTest($file, $message, $condition, $templates, $exception, $outputs, $deprecation);
    }

    /**
     * @dataProvider getLegacyTests
     * @group legacy
     */
    public function testLegacyIntegration($file, $message, $condition, $templates, $exception, $outputs, $deprecation = '')
    {
        $this->doIntegrationTest($file, $message, $condition, $templates, $exception, $outputs, $deprecation);
    }

    public function getTests($name, $legacyTests = false)
    {
        $fixturesDir = realpath($this->getFixturesDir());
        $tests = [];

        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($fixturesDir), \RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            if (!preg_match('/\.test$/', $file)) {
                continue;
            }

            if ($legacyTests xor false !== strpos($file->getRealpath(), '.legacy.test')) {
                continue;
            }

            $test = file_get_contents($file->getRealpath());

            if (preg_match('/--TEST--\s*(.*?)\s*(?:--CONDITION--\s*(.*))?\s*(?:--DEPRECATION--\s*(.*?))?\s*((?:--TEMPLATE(?:\(.*?\))?--(?:.*?))+)\s*(?:--DATA--\s*(.*))?\s*--EXCEPTION--\s*(.*)/sx', $test, $match)) {
                $message = $match[1];
                $condition = $match[2];
                $deprecation = $match[3];
                $templates = self::parseTemplates($match[4]);
                $exception = $match[6];
                $outputs = [[null, $match[5], null, '']];
            } elseif (preg_match('/--TEST--\s*(.*?)\s*(?:--CONDITION--\s*(.*))?\s*(?:--DEPRECATION--\s*(.*?))?\s*((?:--TEMPLATE(?:\(.*?\))?--(?:.*?))+)--DATA--.*?--EXPECT--.*/s', $test, $match)) {
                $message = $match[1];
                $condition = $match[2];
                $deprecation = $match[3];
                $templates = self::parseTemplates($match[4]);
                $exception = false;
                preg_match_all('/--DATA--(.*?)(?:--CONFIG--(.*?))?--EXPECT--(.*?)(?=\-\-DATA\-\-|$)/s', $test, $outputs, \PREG_SET_ORDER);
            } else {
                throw new \InvalidArgumentException(sprintf('Test "%s" is not valid.', str_replace($fixturesDir.'/', '', $file)));
            }

            $tests[] = [str_replace($fixturesDir.'/', '', $file), $message, $condition, $templates, $exception, $outputs, $deprecation];
        }

        if ($legacyTests && empty($tests)) {
            // add a dummy test to avoid a PHPUnit message
            return [['not', '-', '', [], '', []]];
        }

        return $tests;
    }

    public function getLegacyTests()
    {
        return $this->getTests('testLegacyIntegration', true);
    }

    protected function doIntegrationTest($file, $message, $condition, $templates, $exception, $outputs, $deprecation = '')
    {
        if (!$outputs) {
            $this->markTestSkipped('no tests to run');
        }

        if ($condition) {
            eval('$ret = '.$condition.';');
            if (!$ret) {
                $this->markTestSkipped($condition);
            }
        }

        $loader = new ArrayLoader($templates);

        foreach ($outputs as $i => $match) {
            $config = array_merge([
                'cache' => false,
                'strict_variables' => true,
            ], $match[2] ? eval($match[2].';') : []);
            $bubble = new Environment($loader, $config);
            $bubble->addGlobal('global', 'global');
            foreach ($this->getRuntimeLoaders() as $runtimeLoader) {
                $bubble->addRuntimeLoader($runtimeLoader);
            }

            foreach ($this->getExtensions() as $extension) {
                $bubble->addExtension($extension);
            }

            foreach ($this->getBubbleFilters() as $filter) {
                $bubble->addFilter($filter);
            }

            foreach ($this->getBubbleTests() as $test) {
                $bubble->addTest($test);
            }

            foreach ($this->getBubbleFunctions() as $function) {
                $bubble->addFunction($function);
            }

            // avoid using the same PHP class name for different cases
            $p = new \ReflectionProperty($bubble, 'templateClassPrefix');
            $p->setAccessible(true);
            $p->setValue($bubble, '__BubbleTemplate_'.hash('sha256', uniqid(mt_rand(), true), false).'_');

            $deprecations = [];
            try {
                $prevHandler = set_error_handler(function ($type, $msg, $file, $line, $context = []) use (&$deprecations, &$prevHandler) {
                    if (\E_USER_DEPRECATED === $type) {
                        $deprecations[] = $msg;

                        return true;
                    }

                    return $prevHandler ? $prevHandler($type, $msg, $file, $line, $context) : false;
                });

                $template = $bubble->load('index.bubble');
            } catch (\Exception $e) {
                if (false !== $exception) {
                    $message = $e->getMessage();
                    $this->assertSame(trim($exception), trim(sprintf('%s: %s', \get_class($e), $message)));
                    $last = substr($message, \strlen($message) - 1);
                    $this->assertTrue('.' === $last || '?' === $last, 'Exception message must end with a dot or a question mark.');

                    return;
                }

                throw new Error(sprintf('%s: %s', \get_class($e), $e->getMessage()), -1, null, $e);
            } finally {
                restore_error_handler();
            }

            $this->assertSame($deprecation, implode("\n", $deprecations));

            try {
                $output = trim($template->render(eval($match[1].';')), "\n ");
            } catch (\Exception $e) {
                if (false !== $exception) {
                    $this->assertSame(trim($exception), trim(sprintf('%s: %s', \get_class($e), $e->getMessage())));

                    return;
                }

                $e = new Error(sprintf('%s: %s', \get_class($e), $e->getMessage()), -1, null, $e);

                $output = trim(sprintf('%s: %s', \get_class($e), $e->getMessage()));
            }

            if (false !== $exception) {
                list($class) = explode(':', $exception);
                $constraintClass = class_exists('PHPUnit\Framework\Constraint\Exception') ? 'PHPUnit\Framework\Constraint\Exception' : 'PHPUnit_Framework_Constraint_Exception';
                $this->assertThat(null, new $constraintClass($class));
            }

            $expected = trim($match[3], "\n ");

            if ($expected !== $output) {
                printf("Compiled templates that failed on case %d:\n", $i + 1);

                foreach (array_keys($templates) as $name) {
                    echo "Template: $name\n";
                    echo $bubble->compile($bubble->parse($bubble->tokenize($bubble->getLoader()->getSourceContext($name))));
                }
            }
            $this->assertEquals($expected, $output, $message.' (in '.$file.')');
        }
    }

    protected static function parseTemplates($test)
    {
        $templates = [];
        preg_match_all('/--TEMPLATE(?:\((.*?)\))?--(.*?)(?=\-\-TEMPLATE|$)/s', $test, $matches, \PREG_SET_ORDER);
        foreach ($matches as $match) {
            $templates[($match[1] ?: 'index.bubble')] = $match[2];
        }

        return $templates;
    }
}
