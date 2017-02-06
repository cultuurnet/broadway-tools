<?php

namespace CultuurNet\Broadway\EventHandling;

use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Broadway\EventHandling\EventListenerInterface;
use CultuurNet\Broadway\Domain\DomainMessageIsNotReplayed;

class FilteringEventListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DomainMessageIsNotReplayed
     */
    private $notReplayedSpecification;

    /**
     * @var EventListenerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $eventListener;

    /**
     * @var FilteringEventListener
     */
    private $filteringEventListener;

    public function setUp()
    {
        $this->notReplayedSpecification = new DomainMessageIsNotReplayed();
        $this->eventListener = $this->createMock(EventListenerInterface::class);

        $this->filteringEventListener = new FilteringEventListener(
            $this->eventListener,
            $this->notReplayedSpecification
        );
    }

    /**
     * @test
     */
    public function it_ignores_domain_messages_that_do_not_satisfy_the_specification()
    {
        $domainMessage = DomainMessage::recordNow(
            '44ba2574-aa50-4765-a0e5-38b046a13357',
            0,
            new Metadata(['replayed' => true]),
            new \stdClass()
        );

        $this->eventListener->expects($this->never())
            ->method('handle')
            ->with($domainMessage);

        $this->filteringEventListener->handle($domainMessage);
    }

    /**
     * @test
     */
    public function it_delegates_event_handling_to_its_decoratee_if_the_domain_message_satisfies_the_specification()
    {
        $domainMessage = DomainMessage::recordNow(
            '44ba2574-aa50-4765-a0e5-38b046a13357',
            0,
            new Metadata(['replayed' => false]),
            new \stdClass()
        );

        $this->eventListener->expects($this->once())
            ->method('handle')
            ->with($domainMessage);

        $this->filteringEventListener->handle($domainMessage);
    }
}
