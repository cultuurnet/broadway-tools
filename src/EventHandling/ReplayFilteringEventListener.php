<?php

namespace CultuurNet\Broadway\EventHandling;

use Broadway\EventHandling\EventListenerInterface;
use CultuurNet\Broadway\Domain\DomainMessageIsNotReplayed;

class ReplayFilteringEventListener extends FilteringEventListener
{
    /**
     * @param EventListenerInterface $eventListener
     */
    public function __construct(
        EventListenerInterface $eventListener
    ) {
        $domainMessageSpecification = new DomainMessageIsNotReplayed();
        parent::__construct($eventListener, $domainMessageSpecification);
    }
}
