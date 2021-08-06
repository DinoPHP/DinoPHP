<?php



namespace Bubble\Node\Expression;

use Bubble\Compiler;
use Bubble\Node\Node;

/**
 * @internal
 */
final class InlinePrint extends AbstractExpression
{
    public function __construct(Node $node, int $lineno)
    {
        parent::__construct(['node' => $node], [], $lineno);
    }

    public function compile(Compiler $compiler): void
    {
        $compiler
            ->raw('print (')
            ->subcompile($this->getNode('node'))
            ->raw(')')
        ;
    }
}
