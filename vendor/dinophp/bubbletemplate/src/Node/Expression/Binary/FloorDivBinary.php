<?php



namespace Bubble\Node\Expression\Binary;

use Bubble\Compiler;

class FloorDivBinary extends AbstractBinary
{
    public function compile(Compiler $compiler): void
    {
        $compiler->raw('(int) floor(');
        parent::compile($compiler);
        $compiler->raw(')');
    }

    public function operator(Compiler $compiler): Compiler
    {
        return $compiler->raw('/');
    }
}
