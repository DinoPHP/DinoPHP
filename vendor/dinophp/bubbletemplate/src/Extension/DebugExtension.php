<?php



namespace Bubble\Extension {
use Bubble\BubbleFunction;

final class DebugExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        // dump is safe if var_dump is overridden by xdebug
        $isDumpOutputHtmlSafe = \extension_loaded('xdebug')
            // false means that it was not set (and the default is on) or it explicitly enabled
            && (false === ini_get('xdebug.overload_var_dump') || ini_get('xdebug.overload_var_dump'))
            // false means that it was not set (and the default is on) or it explicitly enabled
            // xdebug.overload_var_dump produces HTML only when html_errors is also enabled
            && (false === ini_get('html_errors') || ini_get('html_errors'))
            || 'cli' === \PHP_SAPI
        ;

        return [
            new BubbleFunction('dump', 'bubble_var_dump', ['is_safe' => $isDumpOutputHtmlSafe ? ['html'] : [], 'needs_context' => true, 'needs_environment' => true, 'is_variadic' => true]),
        ];
    }
}
}

namespace {
use Bubble\Environment;
use Bubble\Template;
use Bubble\TemplateWrapper;

function bubble_var_dump(Environment $env, $context, ...$vars)
{
    if (!$env->isDebug()) {
        return;
    }

    ob_start();

    if (!$vars) {
        $vars = [];
        foreach ($context as $key => $value) {
            if (!$value instanceof Template && !$value instanceof TemplateWrapper) {
                $vars[$key] = $value;
            }
        }

        var_dump($vars);
    } else {
        var_dump(...$vars);
    }

    return ob_get_clean();
}
}
