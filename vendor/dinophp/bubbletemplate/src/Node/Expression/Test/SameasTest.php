<?php



namespace Bubble\Node\Expression\Test;

use Bubble\Compiler;
use Bubble\Node\Expression\TestExpression;

/**
 * Checks if a variable is the same as another one (=== in PHP).
*
 */
class SameasTest extends TestExpression
{
    public function compile(Compiler $compiler): void
    {
        $compiler
            ->raw('(')
            ->subcompile($this->getNode('node'))
            ->raw(' === ')
            ->subcompile($this->getNode('arguments')->getNode(0))
            ->raw(')')
        ;
    }
}
