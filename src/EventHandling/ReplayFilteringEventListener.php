<?php

namespace CultuurNet\Broadway\EventHandling;

use Broadway\EventHandling\EventListenerInterface;
use CultuurNet\Broadway\Domain\DomainMessageIsNot;
use CultuurNet\Broadway\Domain\DomainMessageIsReplayed;

class ReplayFilteringEventListener extends FilteringEventListener
{
    /**
     * @param EventListenerInterface $eventListener
     */
    public function __construct(
        EventListenerInterface $eventListener
    ) {
        parent::__construct(
            $eventListener,
            new DomainMessageIsNot(
                new DomainMessageIsReplayed()
            )
        );
    }
}
