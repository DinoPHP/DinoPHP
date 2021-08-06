<?php



namespace Bubble\Sandbox;

/**
 * Interface that all security policy classes must implements.
*
 */
interface SecurityPolicyInterface
{
    /**
     * @throws SecurityError
     */
    public function checkSecurity($tags, $filters, $functions): void;

    /**
     * @throws SecurityNotAllowedMethodError
     */
    public function checkMethodAllowed($obj, $method): void;

    /**
     * @throws SecurityNotAllowedPropertyError
     */
    public function checkPropertyAllowed($obj, $method): void;
}
