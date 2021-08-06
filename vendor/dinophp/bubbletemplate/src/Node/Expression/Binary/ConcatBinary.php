<?php

/*
 * This file is part of Bubble.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bubble\Node\Expression\Binary;

use Bubble\Compiler;

class ConcatBinary extends AbstractBinary
{
    public function operator(Compiler $compiler): Compiler
    {
        return $compiler->raw('.');
    }
}
