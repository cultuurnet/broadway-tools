<?php

namespace CultuurNet\Broadway\EventHandling;

use Broadway\EventHandling\EventListenerInterface;
use CultuurNet\Broadway\Domain\DomainMessageIsNot;
use CultuurNet\Broadway\Domain\DomainMessageIsReplayed;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class ReplayFilteringEventListener extends FilteringEventListener implements LoggerAwareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

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

    /**
     * @inheritDoc
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
