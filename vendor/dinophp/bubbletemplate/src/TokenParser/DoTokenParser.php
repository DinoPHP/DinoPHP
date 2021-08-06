<?php



namespace Bubble\TokenParser;

use Bubble\Node\DoNode;
use Bubble\Node\Node;
use Bubble\Token;

/**
 * Evaluates an expression, discarding the returned value.
 *
 * @internal
 */
final class DoTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): Node
    {
        $expr = $this->parser->getExpressionParser()->parseExpression();

        $this->parser->getStream()->expect(/* Token::BLOCK_END_TYPE */ 3);

        return new DoNode($expr, $token->getLine(), $this->getTag());
    }

    public function getTag(): string
    {
        return 'do';
    }
}
