<?php

namespace CultuurNet\Broadway\Domain;

use Broadway\Domain\DomainMessage;

class DomainMessageIsNotReplayed implements DomainMessageSpecificationInterface
{
    /**
     * @param DomainMessage $domainMessage
     * @return bool
     */
    public function isSatisfiedBy(DomainMessage $domainMessage)
    {
        $metadata = $domainMessage->getMetadata()->serialize();
        return !isset($metadata['replayed']) || !$metadata['replayed'];
    }
}
