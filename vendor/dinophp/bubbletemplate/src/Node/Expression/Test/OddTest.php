<?php



namespace Bubble\Node\Expression\Test;

use Bubble\Compiler;
use Bubble\Node\Expression\TestExpression;

/**
 * Checks if a number is odd.
 *
 *  {{ var is odd }}
*
 */
class OddTest extends TestExpression
{
    public function compile(Compiler $compiler): void
    {
        $compiler
            ->raw('(')
            ->subcompile($this->getNode('node'))
            ->raw(' % 2 != 0')
            ->raw(')')
        ;
    }
}
