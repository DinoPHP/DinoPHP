<?php



namespace Bubble\Extension {
use Bubble\BubbleFunction;

final class StringLoaderExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new BubbleFunction('template_from_string', 'bubble_template_from_string', ['needs_environment' => true]),
        ];
    }
}
}

namespace {
use Bubble\Environment;
use Bubble\TemplateWrapper;

/**
 * Loads a template from a string.
 *
 *     {{ include(template_from_string("Hello {{ name }}")) }}
 *
 * @param string $template A template as a string or object implementing __toString()
 * @param string $name     An optional name of the template to be used in error messages
 */
function bubble_template_from_string(Environment $env, $template, string $name = null): TemplateWrapper
{
    return $env->createTemplate((string) $template, $name);
}
}
