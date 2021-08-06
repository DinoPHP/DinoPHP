<?php



namespace Bubble\Node\Expression\Test;

use Bubble\Compiler;
use Bubble\Node\Expression\TestExpression;

/**
 * Checks that a variable is null.
 *
 *  {{ var is none }}
*
 */
class NullTest extends TestExpression
{
    public function compile(Compiler $compiler): void
    {
        $compiler
            ->raw('(null === ')
            ->subcompile($this->getNode('node'))
            ->raw(')')
        ;
    }
}
