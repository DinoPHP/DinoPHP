<?php



namespace Bubble\TokenParser;

use Bubble\Error\SyntaxError;
use Bubble\Node\Node;
use Bubble\Parser;
use Bubble\Token;

/**
 * Interface implemented by token parsers.
*
 */
interface TokenParserInterface
{
    /**
     * Sets the parser associated with this token parser.
     */
    public function setParser(Parser $parser): void;

    /**
     * Parses a token and returns a node.
     *
     * @return Node
     *
     * @throws SyntaxError
     */
    public function parse(Token $token);

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string
     */
    public function getTag();
}
