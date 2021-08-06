<?php



namespace Bubble\Node\Expression\Binary;

use Bubble\Compiler;

class SpaceshipBinary extends AbstractBinary
{
    public function operator(Compiler $compiler): Compiler
    {
        return $compiler->raw('<=>');
    }
}
