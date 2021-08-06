<?php



namespace Bubble\Extension;

use Bubble\Profiler\NodeVisitor\ProfilerNodeVisitor;
use Bubble\Profiler\Profile;

class ProfilerExtension extends AbstractExtension
{
    private $actives = [];

    public function __construct(Profile $profile)
    {
        $this->actives[] = $profile;
    }

    /**
     * @return void
     */
    public function enter(Profile $profile)
    {
        $this->actives[0]->addProfile($profile);
        array_unshift($this->actives, $profile);
    }

    /**
     * @return void
     */
    public function leave(Profile $profile)
    {
        $profile->leave();
        array_shift($this->actives);

        if (1 === \count($this->actives)) {
            $this->actives[0]->leave();
        }
    }

    public function getNodeVisitors(): array
    {
        return [new ProfilerNodeVisitor(static::class)];
    }
}
