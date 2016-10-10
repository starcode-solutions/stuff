<?php

namespace StarcodeTest\Staff\Service;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Prophecy\Prophecy\ObjectProphecy;
use Starcode\Staff\Exception\InvalidConfigException;
use Starcode\Staff\Service\ConsoleApplicationFactory;
use Symfony\Component\Console\Application;

class ConsoleApplicationFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContainerInterface|ObjectProphecy */
    private $container;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testFactoryFailWhenConsoleConfigNotSet()
    {
        $this->setExpectedException(InvalidConfigException::class, 'Console config not set');

        $consoleApplicationFactory = new ConsoleApplicationFactory();

        $consoleApplicationFactory($this->container->reveal(), Application::class);
    }

    public function testFactorySuccessCreateConsoleApplication()
    {
        $this->container->get('config')->willReturn([
            'console' => [
                'name' => 'Test',
                'version' => '1.0.0',
            ],
        ]);

        /** @var EntityManager|ObjectProphecy $entityManager */
        $entityManager = $this->prophesize(EntityManager::class);
        $entityManager->getConnection()->willReturn($this->prophesize(Connection::class)->reveal());
        $this->container->get(EntityManager::class)->willReturn($entityManager->reveal());

        $consoleApplicationFactory = new ConsoleApplicationFactory();

        /** @var Application $consoleApplication */
        $consoleApplication = $consoleApplicationFactory($this->container->reveal(), Application::class);

        $this->assertInstanceOf(Application::class, $consoleApplication);
        $this->assertEquals('Test', $consoleApplication->getName());
        $this->assertEquals('1.0.0', $consoleApplication->getVersion());
    }

    public function testServiceManagerReturnConsoleApplication()
    {
        /** @var ContainerInterface $container */
        $container = require(__DIR__ . '/../../../../config/container.php');

        $consoleApplication = $container->get(Application::class);

        $this->assertInstanceOf(Application::class, $consoleApplication);
    }
}