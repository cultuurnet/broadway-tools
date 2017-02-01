<?php

namespace CultuurNet\Broadway\Domain;

use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;

class DomainMessageIsNotReplayedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DomainMessageIsNotReplayed
     */
    private $specification;

    /**
     * @var string
     */
    private $mockAggregateId;

    /**
     * @var \stdClass
     */
    private $mockEvent;

    public function setUp()
    {
        $this->specification = new DomainMessageIsNotReplayed();

        $this->mockAggregateId = 'd3484c13-41dc-4b38-9b08-fa9a43fe415b';
        $this->mockEvent = new \stdClass();
    }

    /**
     * @test
     */
    public function it_is_satisfied_by_domain_messages_with_no_replay_flag_in_their_metadata()
    {
        $domainMessage = $this->getDomainMessageWithMetadata(
            new Metadata([])
        );

        $this->assertTrue($this->specification->isSatisfiedBy($domainMessage));
    }

    /**
     * @test
     */
    public function it_is_satisfied_by_domain_messages_with_a_replay_flag_set_to_false_in_their_metadata()
    {
        $domainMessage = $this->getDomainMessageWithMetadata(
            new Metadata(['replay' => false])
        );

        $this->assertTrue($this->specification->isSatisfiedBy($domainMessage));
    }

    /**
     * @test
     */
    public function it_is_not_satisfied_by_domain_messages_with_a_replay_flag_set_to_true_in_their_metadata()
    {
        $domainMessage = $this->getDomainMessageWithMetadata(
            new Metadata(['replay' => true])
        );

        $this->assertTrue($this->specification->isSatisfiedBy($domainMessage));
    }

    /**
     * @param Metadata $metadata
     * @return DomainMessage
     */
    private function getDomainMessageWithMetadata(Metadata $metadata)
    {
        return DomainMessage::recordNow(
            $this->mockAggregateId,
            0,
            $metadata,
            $this->mockEvent
        );
    }
}
