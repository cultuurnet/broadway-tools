<?php

namespace CultuurNet\Broadway\Domain;

use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;

class DomainMessageCallbackSpecificationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_calls_the_callback_for_every_domain_message_and_returns_the_result_as_a_bool()
    {
        $validId = '5f8a6645-7373-4d59-8bd8-fd4cbfa64144';

        $aggregateIdCallback = function (DomainMessage $domainMessage) use ($validId) {
            $valid = $domainMessage->getId() == $validId;

            // Return as int to make sure it gets converted to bool by the
            // specification.
            return (int) $valid;
        };

        $specification = new DomainMessageCallbackSpecification($aggregateIdCallback);

        $validDomainMessage = DomainMessage::recordNow(
            $validId,
            0,
            new Metadata([]),
            new \stdClass()
        );

        $invalidDomainMessage = DomainMessage::recordNow(
            'b789dafd-0bfe-4b21-a1db-aa15e7a46f30',
            0,
            new Metadata([]),
            new \stdClass()
        );

        // These assertions also check type instead of casting to bool.
        $this->assertTrue($specification->isSatisfiedBy($validDomainMessage));
        $this->assertFalse($specification->isSatisfiedBy($invalidDomainMessage));
    }
}
