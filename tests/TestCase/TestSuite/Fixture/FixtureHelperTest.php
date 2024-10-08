<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         4.3.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\TestCase\TestSuite;

use Cake\Core\Exception\CakeException;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionInterface;
use Cake\Datasource\ConnectionManager;
use Cake\Test\Fixture\ArticlesFixture;
use Cake\TestSuite\Fixture\FixtureHelper;
use Cake\TestSuite\Fixture\TestFixture;
use Cake\TestSuite\TestCase;
use Company\TestPluginThree\Test\Fixture\ArticlesFixture as CompanyArticlesFixture;
use PDOException;
use TestApp\Test\Fixture\ArticlesFixture as AppArticlesFixture;
use TestPlugin\Test\Fixture\ArticlesFixture as PluginArticlesFixture;
use TestPlugin\Test\Fixture\Blog\CommentsFixture as PluginCommentsFixture;
use UnexpectedValueException;

class FixtureHelperTest extends TestCase
{
    protected array $fixtures = ['core.Articles'];

    /**
     * Clean up after test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->clearPlugins();
        ConnectionManager::dropAlias('test1');
        ConnectionManager::dropAlias('test2');
    }

    /**
     * Tests loading fixtures.
     */
    public function testLoadFixtures(): void
    {
        $this->setAppNamespace('TestApp');
        $this->loadPlugins(['TestPlugin']);
        $fixtures = (new FixtureHelper())->loadFixtures([
            'core.Articles',
            'plugin.TestPlugin.Articles',
            'plugin.TestPlugin.Blog/Comments',
            'plugin.Company/TestPluginThree.Articles',
            'app.Articles',
        ]);
        $this->assertNotEmpty($fixtures);
        $this->assertInstanceOf(ArticlesFixture::class, $fixtures[ArticlesFixture::class]);
        $this->assertInstanceOf(PluginArticlesFixture::class, $fixtures[PluginArticlesFixture::class]);
        $this->assertInstanceOf(PluginCommentsFixture::class, $fixtures[PluginCommentsFixture::class]);
        $this->assertInstanceOf(CompanyArticlesFixture::class, $fixtures[CompanyArticlesFixture::class]);
        $this->assertInstanceOf(AppArticlesFixture::class, $fixtures[AppArticlesFixture::class]);
    }

    /**
     * Tests that possible table instances used in the fixture loading mechanism
     * do not remain in the table locator.
     */
    public function testLoadFixturesDoesNotPolluteTheTableLocator(): void
    {
        (new FixtureHelper())->loadFixtures([
            'core.Articles',
            'plugin.TestPlugin.Blog/Comments',
        ]);

        $this->assertFalse($this->getTableLocator()->exists('Articles'));
        $this->assertFalse($this->getTableLocator()->exists('Comments'));
    }

    /**
     * Tests loading missing fixtures.
     */
    public function testLoadMissingFixtures(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Could not find fixture `core.ThisIsMissing`');
        (new FixtureHelper())->loadFixtures(['core.ThisIsMissing']);
    }

    /**
     * Tests loading duplicate fixtures.
     */
    public function testLoadDulicateFixtures(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Found duplicate fixture `core.Articles`');
        (new FixtureHelper())->loadFixtures(['core.Articles','core.Articles']);
    }

    /**
     * Tests running callback per connection
     */
    public function testPerConnection(): void
    {
        $fixture1 = new class extends TestFixture {
            public function connection(): string
            {
                return 'test1';
            }

            protected function _schemaFromReflection(): void
            {
            }
        };
        $fixture2 = new class extends TestFixture {
            public function connection(): string
            {
                return 'test2';
            }

            protected function _schemaFromReflection(): void
            {
            }
        };

        ConnectionManager::alias('test', 'test1');
        ConnectionManager::alias('test', 'test2');

        $numCalls = 0;
        (new FixtureHelper())->runPerConnection(function () use (&$numCalls): void {
            ++$numCalls;
        }, [$fixture1, $fixture2]);
        $this->assertSame(2, $numCalls);
    }

    /**
     * Tests inserting fixtures.
     */
    public function testInsertFixtures(): void
    {
        /**
         * @var \Cake\Database\Connection $connection
         */
        $connection = ConnectionManager::get('test');
        $connection->deleteQuery()->delete('articles')->execute()->closeCursor();
        $rows = $connection->selectQuery()->select('*')->from('articles')->execute();
        $this->assertEmpty($rows->fetchAll());
        $rows->closeCursor();

        $helper = new FixtureHelper();
        $helper->insert($helper->loadFixtures(['core.Articles']));
        $rows = $connection->selectQuery()->select('*')->from('articles')->execute();
        $this->assertNotEmpty($rows->fetchAll());
        $rows->closeCursor();
    }

    /**
     * Tests handling PDO errors when inserting rows.
     */
    public function testInsertFixturesException(): void
    {
        $fixture = new class extends TestFixture {
            public function connection(): string
            {
                return 'test';
            }

            protected function _schemaFromReflection(): void
            {
            }

            public function insert(ConnectionInterface $connection): bool
            {
                throw new PDOException('Missing key');
            }
        };

        $helper = new class extends FixtureHelper {
            public function sortByConstraint(Connection $connection, array $fixtures): array
            {
                return [new class extends TestFixture {
                    public function connection(): string
                    {
                        return 'test';
                    }

                    protected function _schemaFromReflection(): void
                    {
                    }

                    public function insert(ConnectionInterface $connection): bool
                    {
                        throw new PDOException('Missing key');
                    }
                }];
            }
        };

        $this->expectException(CakeException::class);
        $this->expectExceptionMessage('Unable to insert rows for table `');
        $helper->insert([$fixture]);
    }

    /**
     * Tests truncating fixtures.
     */
    public function testTruncateFixtures(): void
    {
        /**
         * @var \Cake\Database\Connection $connection
         */
        $connection = ConnectionManager::get('test');
        $rows = $connection->selectQuery()->select('*')->from('articles')->execute();
        $this->assertNotEmpty($rows->fetchAll());
        $rows->closeCursor();

        $helper = new FixtureHelper();
        $helper->truncate($helper->loadFixtures(['core.Articles']));
        $rows = $connection->selectQuery()->select('*')->from('articles')->execute();
        $this->assertEmpty($rows->fetchAll());
        $rows->closeCursor();
    }

    /**
     * Tests handling PDO errors when trucating rows.
     */
    public function testTruncateFixturesException(): void
    {
        $fixture = new class extends TestFixture {
            public function connection(): string
            {
                return 'test';
            }

            protected function _schemaFromReflection(): void
            {
            }

            public function truncate(ConnectionInterface $connection): bool
            {
                throw new PDOException('Missing key');
            }
        };

        $helper = new class extends FixtureHelper {
            public function sortByConstraint(Connection $connection, array $fixtures): array
            {
                return [new class extends TestFixture {
                    public function connection(): string
                    {
                        return 'test';
                    }

                    protected function _schemaFromReflection(): void
                    {
                    }

                    public function truncate(ConnectionInterface $connection): bool
                    {
                        throw new PDOException('Missing key');
                    }
                }];
            }
        };

        $this->expectException(CakeException::class);
        $this->expectExceptionMessage('Unable to truncate table `');
        $helper->truncate([$fixture]);
    }
}
