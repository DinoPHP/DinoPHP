<?php



namespace Bubble\TokenParser;

use Bubble\Node\DeprecatedNode;
use Bubble\Node\Node;
use Bubble\Token;

/**
 * Deprecates a section of a template.
 *
 *    {% deprecated 'The "base.bubble" template is deprecated, use "layout.bubble" instead.' %}
 *    {% extends 'layout.html.bubble' %}
 *
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 *
 * @internal
 */
final class DeprecatedTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): Node
    {
        $expr = $this->parser->getExpressionParser()->parseExpression();

        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);

        return new DeprecatedNode($expr, $token->getLine(), $this->getTag());
    }

    public function getTag(): string
    {
        return 'deprecated';
    }
}
