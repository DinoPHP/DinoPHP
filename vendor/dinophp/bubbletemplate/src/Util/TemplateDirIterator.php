<?php



namespace Bubble\Util;


class TemplateDirIterator extends \IteratorIterator
{
    public function current()
    {
        return file_get_contents(parent::current());
    }

    public function key()
    {
        return (string) parent::key();
    }
}
