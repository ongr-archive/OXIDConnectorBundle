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
     * Sets up required info before each test.
     */
    public function setUp()
    {
        $vendorDir = $this->getRootDir($this->getServiceContainer()) . '/../../vendor';
        AnnotationRegistry::registerFile(
            $vendorDir . '/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
        );
    }

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
     * @throws \Exception
     */
    protected function getServiceContainer()
    {
        if ($this->container) {
            return $this->container;
        }

        try {
            $this->container = self::createClient()->getContainer();

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return $this->container;
    }

    /**
     * Gets Entity manager from container.
     *
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        /** @var $doctrine RegistryInterface */
        $doctrine = $this->getServiceContainer()->get('doctrine');

        return $doctrine->getManager();
    }

    /**
     * Imports mySQL schema and data.
     */
    public static function setUpBeforeClass()
    {
        $container = self::createClient()->getContainer();
        /** @var EntityManager $entityManager */
        $entityManager = $container->get('doctrine')->getManager();
        $connection = $entityManager->getConnection();
        $params = $connection->getParams();
        $name = $connection->getDatabasePlatform()->quoteSingleIdentifier($connection->getParams()['dbname']);
        unset($params['dbname']);
        $tmpConnection = DriverManager::getConnection($params);
        $tmpConnection->getSchemaManager()->createDatabase($name);
        $tmpConnection->close();
        $schema = self::getRootDir($container) . '/data/database.sql';
        $data = self::getRootDir($container) . '/data/dummyData.sql';
        self::executeSqlFile($connection, $schema);
        self::executeSqlFile($connection, $data);
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
    private static function getRootDir($container)
    {
        return $container->get('kernel')->getRootDir();
    }
}
