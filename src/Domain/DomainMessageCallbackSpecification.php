<?php

namespace CultuurNet\Broadway\Domain;

use Broadway\Domain\DomainMessage;

class DomainMessageCallbackSpecification implements DomainMessageSpecificationInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param DomainMessage $domainMessage
     * @return bool
     */
    public function isSatisfiedBy(DomainMessage $domainMessage)
    {
        return (bool) call_user_func($this->callback, $domainMessage);
    }
}
