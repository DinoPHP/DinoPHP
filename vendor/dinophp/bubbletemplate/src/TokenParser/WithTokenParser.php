<?php



namespace Bubble\TokenParser;

use Bubble\Node\Node;
use Bubble\Node\WithNode;
use Bubble\Token;

/**
 * Creates a nested scope.
*
 *
 * @internal
 */
final class WithTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): Node
    {
        $stream = $this->parser->getStream();

        $variables = null;
        $only = false;
        if (!$stream->test(/* Token::BLOCK_END_TYPE */ 3)) {
            $variables = $this->parser->getExpressionParser()->parseExpression();
            $only = (bool) $stream->nextIf(/* Token::NAME_TYPE */ 5, 'only');
        }

        $stream->expect(/* Token::BLOCK_END_TYPE */ 3);

        $body = $this->parser->subparse([$this, 'decideWithEnd'], true);

        $stream->expect(/* Token::BLOCK_END_TYPE */ 3);

        return new WithNode($body, $variables, $only, $token->getLine(), $this->getTag());
    }

    public function decideWithEnd(Token $token): bool
    {
        return $token->test('endwith');
    }

    public function getTag(): string
    {
        return 'with';
    }
}
