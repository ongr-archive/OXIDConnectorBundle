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
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\DriverManager;

/**
 * Class TestBase.
 */
abstract class TestBase extends WebTestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

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
     * Returns service container, creates new if it does not exist.
     *
     * @return ContainerInterface
     */
    protected function getServiceContainer()
    {
        if ($this->container === null) {
            $this->container = self::createClient()->getContainer();
        }

        return $this->container;
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
        $container = self::createClient()->getContainer();

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
        $container = self::createClient()->getContainer();
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
}
