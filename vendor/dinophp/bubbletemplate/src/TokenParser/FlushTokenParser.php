<?php



namespace Bubble\TokenParser;

use Bubble\Node\FlushNode;
use Bubble\Node\Node;
use Bubble\Token;

/**
 * Flushes the output to the client.
 *
 * @see flush()
 *
 * @internal
 */
final class FlushTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): Node
    {
        $this->parser->getStream()->expect(/* Token::BLOCK_END_TYPE */ 3);

        return new FlushNode($token->getLine(), $this->getTag());
    }

    public function getTag(): string
    {
        return 'flush';
    }
}
