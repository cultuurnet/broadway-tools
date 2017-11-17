<?php

namespace CultuurNet\Broadway\CommandHandling\Validation;

use Broadway\CommandHandling\CommandBusInterface;
use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\CommandHandlerInterface;

class ValidatingCommandBusDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommandBusInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $decoratee;

    /**
     * @var CommandValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $validator;

    /**
     * @var ValidatingCommandBusDecorator
     */
    private $decorator;

    public function setUp()
    {
        $this->decoratee = $this->createMock(CommandBusInterface::class);
        $this->validator = $this->createMock(CommandValidatorInterface::class);

        $this->decorator = new ValidatingCommandBusDecorator(
            $this->decoratee,
            $this->validator
        );
    }

    /**
     * @test
     */
    public function it_should_validate_each_command_before_dispatching_it_to_the_decoratee()
    {
        $command1 = (object) ['do' => 'something 1'];
        $command2 = (object) ['do' => 'something 2'];
        $command3 = (object) ['do' => 'something 3'];

        $this->validator->expects($this->exactly(3))
            ->method('validate')
            ->withConsecutive(
                [$command1],
                [$command2],
                [$command3]
            );

        $this->decoratee->expects($this->exactly(3))
            ->method('dispatch')
            ->withConsecutive(
                [$command1],
                [$command2],
                [$command3]
            );

        $this->decorator->dispatch($command1);
        $this->decorator->dispatch($command2);
        $this->decorator->dispatch($command3);
    }

    /**
     * @test
     */
    public function it_should_delegate_subscriptions_to_the_decoratee()
    {
        /* @var CommandHandlerInterface $handler */
        $handler = $this->createMock(CommandHandlerInterface::class);

        $this->decoratee->expects($this->once())
            ->method('subscribe')
            ->with($handler);

        $this->decorator->subscribe($handler);
    }
}
