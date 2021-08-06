<?php



namespace Bubble\Extension;

use Bubble\NodeVisitor\NodeVisitorInterface;
use Bubble\TokenParser\TokenParserInterface;
use Bubble\BubbleFilter;
use Bubble\BubbleFunction;
use Bubble\BubbleTest;

/**
 * Used by \Bubble\Environment as a staging area.
*
 *
 * @internal
 */
final class StagingExtension extends AbstractExtension
{
    private $functions = [];
    private $filters = [];
    private $visitors = [];
    private $tokenParsers = [];
    private $tests = [];

    public function addFunction(BubbleFunction $function): void
    {
        if (isset($this->functions[$function->getName()])) {
            throw new Exception(sprintf('Function "%s" is already registered.', $function->getName()));
        }

        $this->functions[$function->getName()] = $function;
    }

    public function getFunctions(): array
    {
        return $this->functions;
    }

    public function addFilter(BubbleFilter $filter): void
    {
        if (isset($this->filters[$filter->getName()])) {
            throw new Exception(sprintf('Filter "%s" is already registered.', $filter->getName()));
        }

        $this->filters[$filter->getName()] = $filter;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function addNodeVisitor(NodeVisitorInterface $visitor): void
    {
        $this->visitors[] = $visitor;
    }

    public function getNodeVisitors(): array
    {
        return $this->visitors;
    }

    public function addTokenParser(TokenParserInterface $parser): void
    {
        if (isset($this->tokenParsers[$parser->getTag()])) {
            throw new Exception(sprintf('Tag "%s" is already registered.', $parser->getTag()));
        }

        $this->tokenParsers[$parser->getTag()] = $parser;
    }

    public function getTokenParsers(): array
    {
        return $this->tokenParsers;
    }

    public function addTest(BubbleTest $test): void
    {
        if (isset($this->tests[$test->getName()])) {
            throw new Exception(sprintf('Test "%s" is already registered.', $test->getName()));
        }

        $this->tests[$test->getName()] = $test;
    }

    public function getTests(): array
    {
        return $this->tests;
    }
}
