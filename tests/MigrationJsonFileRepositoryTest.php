<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Migration\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Migration\MigrationJsonFileRepository;
use Tobento\Service\Migration\MigrationRepositoryInterface;
use Tobento\Service\Migration\MigrationResult;
use Tobento\Service\Migration\Test\Mock\BlogMigration;
use Tobento\Service\Migration\Test\Mock\ShopMigration;

/**
 * MigrationJsonFileRepositoryTest tests
 */
class MigrationJsonFileRepositoryTest extends TestCase
{
    public function testIsInstanceofMigrationRepositoryInterface()
    {
        $repo = new MigrationJsonFileRepository(__DIR__.'/tmp/migrations/');
            
        $this->assertInstanceOf(
            MigrationRepositoryInterface::class,
            $repo
        );       
    }

    public function testStoreMethod()
    {
        $repo = new MigrationJsonFileRepository(__DIR__.'/tmp/migrations/');
        
        $migration = new BlogMigration();
        $actions = $migration->install();
        $result = new MigrationResult($migration, $actions);
        
        $this->assertSame(
            ['migration' => $migration::class],
            $repo->store($migration::class, $result)
        );

        $this->assertSame(
            [$migration::class],
            $repo->getMigrations()
        );
        
        $repo->deleteAll();
    }
    
    public function testFetchMethod()
    {
        $repo = new MigrationJsonFileRepository(__DIR__.'/tmp/migrations/');
        
        $migration = new BlogMigration();
        $actions = $migration->install();
        $result = new MigrationResult($migration, $actions);
        $repo->store($migration::class, $result);
        
        $this->assertSame(
            ['migration' => $migration::class],
            $repo->fetch($migration::class)
        );
        
        $repo->deleteAll();
    }    
    
    public function testGetMigrationsMethodReturnsEmptyArrayIfNoMigrationsYet()
    {
        $repo = new MigrationJsonFileRepository(__DIR__.'/tmp/migrations/');
        
        $this->assertSame(
            [],
            $repo->getMigrations()
        );  
    }
    
    public function testGetMigrationsMethodReturnsMigrations()
    {
        $repo = new MigrationJsonFileRepository(__DIR__.'/tmp/migrations/');
        
        $migration = new BlogMigration();
        $actions = $migration->install();
        $result = new MigrationResult($migration, $actions);
        $repo->store($migration::class, $result);
        
        $shopMigration = new ShopMigration();
        $actions = $shopMigration->install();
        $result = new MigrationResult($shopMigration, $actions);
        $repo->store($shopMigration::class, $result);
            
        $this->assertSame(
            [$migration::class, $shopMigration::class],
            $repo->getMigrations()
        ); 
        
        $repo->deleteAll();
    }
    
    public function testDeleteMethod()
    {
        $repo = new MigrationJsonFileRepository(__DIR__.'/tmp-foo/migrations/');
        
        $migration = new BlogMigration();
        $actions = $migration->install();
        $result = new MigrationResult($migration, $actions);
        $repo->store($migration::class, $result);
        
        $shopMigration = new ShopMigration();
        $actions = $shopMigration->install();
        $result = new MigrationResult($shopMigration, $actions);
        $repo->store($shopMigration::class, $result);
        
        $this->assertSame(
            ['migration' => $migration::class],
            $repo->delete($migration::class, $result)
        );
        
        $this->assertSame(
            [1 => $shopMigration::class],
            $repo->getMigrations()
        ); 
        
        $repo->deleteAll();
    }    
}