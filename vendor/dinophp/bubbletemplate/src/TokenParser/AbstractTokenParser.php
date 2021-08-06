<?php



namespace Bubble\TokenParser;

use Bubble\Parser;

/**
 * Base class for all token parsers.
*
 */
abstract class AbstractTokenParser implements TokenParserInterface
{
    /**
     * @var Parser
     */
    protected $parser;

    public function setParser(Parser $parser): void
    {
        $this->parser = $parser;
    }
}
