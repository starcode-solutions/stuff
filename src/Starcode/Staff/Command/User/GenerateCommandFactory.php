<?php

namespace Starcode\Staff\Command\User;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Starcode\Staff\Util\Console\ProgressBarBuilder;
use Zend\ServiceManager\Factory\FactoryInterface;

class GenerateCommandFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get(EntityManager::class);
        return new GenerateCommand($entityManager, new ProgressBarBuilder());
    }
}