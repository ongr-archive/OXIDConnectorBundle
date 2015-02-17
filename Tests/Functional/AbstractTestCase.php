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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
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
abstract class AbstractTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Return an array of elements required for testing.
     *
     * @param array  $ids
     * @param string $repository
     *
     * @return Object[]
     */
    protected function getTestElements(array $ids, $repository)
    {
        $items = [];
        $entityManager = $this->getEntityManager();
        $rep = $entityManager->getRepository($repository);
        foreach ($ids as $id) {
            $element = $rep->find($id);
            if ($element !== null) {
                $items[] = $element;
            }
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->client = self::createClient();
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Reboots kernel re-caching resources.
     */
    public function rebootKernel()
    {
        $this->client = self::createClient();
    }

    /**
     * Returns service container, creates new if it does not exist.
     *
     * @return ContainerInterface
     */
    protected function getServiceContainer()
    {
        if ($this->client === null) {
            $this->client = self::createClient();
        }

        return $this->client->getContainer();
    }

    /**
     * Gets entity manager.
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceContainer()->get('doctrine')->getManager();
    }

    /**
     * Prepares DB for tests.
     */
    public static function setUpBeforeClass()
    {
        AnnotationRegistry::registerFile(
            'vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
        );
        self::createClient();
        $container = self::$kernel->getContainer();

        $container
            ->get('es.manager')
            ->getConnection()
            ->dropAndCreateIndex();

        $connection = DriverManager::getConnection(
            [
                'driver' => $container->getParameter('database_driver'),
                'host' => $container->getParameter('database_host'),
                'port' => $container->getParameter('database_port'),
                'user' => $container->getParameter('database_user'),
                'password' => $container->getParameter('database_password'),
                'charset' => 'UTF8',
            ]
        );
        $connection->getSchemaManager()->dropAndCreateDatabase($container->getParameter('database_name'));

        self::executeSqlFile($connection, self::getRootDir($container) . '/data/database.sql');
        self::executeSqlFile($connection, self::getRootDir($container) . '/data/dummyData.sql');

        $connection->close();
    }

    /**
     * Deletes the database.
     */
    public static function tearDownAfterClass()
    {
        self::createClient();
        $container = self::$kernel->getContainer();
        /** @var EntityManager $entityManager */
        $entityManager = $container->get('doctrine')->getManager();
        $connection = $entityManager->getConnection();
        $connection->getSchemaManager()->dropDatabase($connection->getParams()['dbname']);
    }

    /**
     * Imports sql file for testing.
     *
     * @param string $file
     */
    public function importData($file)
    {
        $this->executeSqlFile($this->getEntityManager()->getConnection(), 'Tests/Functional/Fixtures/' . $file);
    }

    /**
     * Executes an SQL file.
     *
     * @param Connection $conn
     * @param string     $file
     */
    protected static function executeSqlFile(Connection $conn, $file)
    {
        $sql = file_get_contents($file);
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    /**
     * Return full path to kernel root dir.
     *
     * @param ContainerInterface $container
     *
     * @return string
     */
    public static function getRootDir($container)
    {
        return $container->get('kernel')->getRootDir();
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
        $application = new Application($this->getClient()->getKernel());
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

    /**
     * Gets Connection from container.
     *
     * @return Connection
     */
    protected function getConnection()
    {
        /** @var $doctrine RegistryInterface */
        $doctrine = $this->getServiceContainer()->get('doctrine');

        return $doctrine->getConnection();
    }
}
