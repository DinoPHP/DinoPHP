<?php

/**
 * @author Ahmed Mohamed Ibrahim
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Bubble;

/**
 * Marks a content as safe.
*
 */
class Markup implements \Countable, \JsonSerializable
{
    private $content;
    private $charset;

    public function __construct($content, $charset)
    {
        $this->content = (string) $content;
        $this->charset = $charset;
    }

    public function __toString()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function count()
    {
        return mb_strlen($this->content, $this->charset);
    }

    public function jsonSerialize()
    {
        return $this->content;
    }
}
