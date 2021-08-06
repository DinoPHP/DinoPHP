<?php



namespace Bubble\Extension;

/**
 * Enables usage of the deprecated Bubble\Extension\AbstractExtension::getGlobals() method.
 *
 * Explicitly implement this interface if you really need to implement the
 * deprecated getGlobals() method in your extensions.
*
 */
interface GlobalsInterface
{
    public function getGlobals(): array;
}
