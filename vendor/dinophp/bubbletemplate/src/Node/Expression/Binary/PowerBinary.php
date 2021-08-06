<?php



namespace Bubble\Node\Expression\Binary;

use Bubble\Compiler;

class PowerBinary extends AbstractBinary
{
    public function operator(Compiler $compiler): Compiler
    {
        return $compiler->raw('**');
    }
}
