<?php



namespace Bubble\Node\Expression;

use Bubble\Compiler;

class VariadicExpression extends ArrayExpression
{
    public function compile(Compiler $compiler): void
    {
        $compiler->raw('...');

        parent::compile($compiler);
    }
}
