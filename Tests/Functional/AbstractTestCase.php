<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Tests\Functional;

use ONGR\ConnectionsBundle\Tests\Functional\AbstractTestCase as ParentTestBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Client;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\DriverManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends ParentTestBase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $container = static::createClient()->getContainer();
        $container->get('es.manager')->getConnection()->dropAndCreateIndex();

        parent::setUp();

        $this->executeLargeSqlFile(static::getRootDir($container) . '/data/database.sql');
        $this->executeLargeSqlFile(static::getRootDir($container) . '/data/dummyData.sql');
    }

    /**
     * Executes specified command.
     *
     * @param ContainerAwareCommand $commandInstance
     * @param string                $commandNamespace
     * @param array                 $parameters
     *
     * @return CommandTester
     */
    protected function executeCommand(
        ContainerAwareCommand $commandInstance,
        $commandNamespace,
        array $parameters = []
    ) {
        $application = new Application(self::createClient()->getKernel());
        $commandInstance->setContainer($this->getServiceContainer());
        $application->add($commandInstance);
        $command = $application->find($commandNamespace);
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array_merge_recursive(
                ['command' => $command->getName()],
                $parameters
            )
        );

        return $commandTester;
    }
}
