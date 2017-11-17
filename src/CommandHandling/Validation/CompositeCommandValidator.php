<?php

namespace CultuurNet\Broadway\CommandHandling\Validation;

class CompositeCommandValidator implements CommandValidatorInterface
{
    /**
     * @var CommandValidatorInterface[]
     */
    private $commandValidators;

    public function __construct(CommandValidatorInterface ...$commandValidators)
    {
        $this->commandValidators = $commandValidators;
    }

    /**
     * @inheritdoc
     */
    public function validate($command)
    {
        foreach ($this->commandValidators as $commandValidator) {
            $commandValidator->validate($command);
        }
    }
}
