<?php



namespace Bubble\Profiler\NodeVisitor;

use Bubble\Environment;
use Bubble\Node\BlockNode;
use Bubble\Node\BodyNode;
use Bubble\Node\MacroNode;
use Bubble\Node\ModuleNode;
use Bubble\Node\Node;
use Bubble\NodeVisitor\NodeVisitorInterface;
use Bubble\Profiler\Node\EnterProfileNode;
use Bubble\Profiler\Node\LeaveProfileNode;
use Bubble\Profiler\Profile;


final class ProfilerNodeVisitor implements NodeVisitorInterface
{
    private $extensionName;

    public function __construct(string $extensionName)
    {
        $this->extensionName = $extensionName;
    }

    public function enterNode(Node $node, Environment $env): Node
    {
        return $node;
    }

    public function leaveNode(Node $node, Environment $env): ?Node
    {
        if ($node instanceof ModuleNode) {
            $varName = $this->getVarName();
            $node->setNode('display_start', new Node([new EnterProfileNode($this->extensionName, Profile::TEMPLATE, $node->getTemplateName(), $varName), $node->getNode('display_start')]));
            $node->setNode('display_end', new Node([new LeaveProfileNode($varName), $node->getNode('display_end')]));
        } elseif ($node instanceof BlockNode) {
            $varName = $this->getVarName();
            $node->setNode('body', new BodyNode([
                new EnterProfileNode($this->extensionName, Profile::BLOCK, $node->getAttribute('name'), $varName),
                $node->getNode('body'),
                new LeaveProfileNode($varName),
            ]));
        } elseif ($node instanceof MacroNode) {
            $varName = $this->getVarName();
            $node->setNode('body', new BodyNode([
                new EnterProfileNode($this->extensionName, Profile::MACRO, $node->getAttribute('name'), $varName),
                $node->getNode('body'),
                new LeaveProfileNode($varName),
            ]));
        }

        return $node;
    }

    private function getVarName(): string
    {
        return sprintf('__internal_%s', hash('sha256', $this->extensionName));
    }

    public function getPriority(): int
    {
        return 0;
    }
}
