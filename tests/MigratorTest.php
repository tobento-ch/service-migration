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
use Tobento\Service\Migration\Migrator;
use Tobento\Service\Migration\MigratorInterface;
use Tobento\Service\Migration\MigrationInstallException;
use Tobento\Service\Migration\MigrationUninstallException;
use Tobento\Service\Migration\AutowiringMigrationFactory;
use Tobento\Service\Migration\MigrationJsonFileRepository;
use Tobento\Service\Migration\MigrationResultInterface;
use Tobento\Service\Migration\Test\Mock\BlogMigration;
use Tobento\Service\Migration\Test\Mock\ShopMigration;
use Tobento\Service\Migration\Test\Mock\FailingActionMigration;
use Tobento\Service\Container\Container;

/**
 * MigratorTest tests
 */
class MigratorTest extends TestCase
{
    public function testIsInstanceofMigratorInterface()
    { 
        $migrator = new Migrator(
            new AutowiringMigrationFactory(new Container()),
            new MigrationJsonFileRepository(__DIR__.'/tmp/migrator/'),
        );

        $this->assertInstanceOf(
            MigratorInterface::class,
            $migrator
        );      
    }
    
    public function testInstallMethodWithObject()
    {
        $migrator = new Migrator(
            new AutowiringMigrationFactory(new Container()),
            new MigrationJsonFileRepository(__DIR__.'/tmp/migrator/'),
        );

        $result = $migrator->install(new BlogMigration());
        
        $this->assertInstanceOf(
            MigrationResultInterface::class,
            $result
        );    
        
        $migrator->uninstall(new BlogMigration());
    }
    
    public function testInstallMethodWithString()
    {
        $migrator = new Migrator(
            new AutowiringMigrationFactory(new Container()),
            new MigrationJsonFileRepository(__DIR__.'/tmp/migrator/'),
        );

        $result = $migrator->install(BlogMigration::class);
        
        $this->assertInstanceOf(
            MigrationResultInterface::class,
            $result
        );
        
        $migrator->uninstall(BlogMigration::class);
    }
    
    public function testInstallMethodThrowsMigrationInstallExceptionIfActionFails()
    {
        $this->expectException(MigrationInstallException::class);
        
        $migrator = new Migrator(
            new AutowiringMigrationFactory(new Container()),
            new MigrationJsonFileRepository(__DIR__.'/tmp/migrator/'),
        );

        $migrator->install(FailingActionMigration::class);
    }
    
    public function testUninstallMethodWithObject()
    {
        $migrator = new Migrator(
            new AutowiringMigrationFactory(new Container()),
            new MigrationJsonFileRepository(__DIR__.'/tmp/migrator/'),
        );

        $result = $migrator->uninstall(new BlogMigration());
        
        $this->assertInstanceOf(
            MigrationResultInterface::class,
            $result
        );
    }
    
    public function testUninstallMethodWithString()
    {
        $migrator = new Migrator(
            new AutowiringMigrationFactory(new Container()),
            new MigrationJsonFileRepository(__DIR__.'/tmp/migrator/'),
        );

        $result = $migrator->uninstall(BlogMigration::class);
        
        $this->assertInstanceOf(
            MigrationResultInterface::class,
            $result
        );
    }
    
    public function testUninstallMethodThrowsMigrationUninstallExceptionIfActionFails()
    {
        $this->expectException(MigrationUninstallException::class);
        
        $migrator = new Migrator(
            new AutowiringMigrationFactory(new Container()),
            new MigrationJsonFileRepository(__DIR__.'/tmp/migrator/'),
        );

        $migrator->uninstall(FailingActionMigration::class);
    }
    
    public function testGetInstalledMethod()
    {
        $migrator = new Migrator(
            new AutowiringMigrationFactory(new Container()),
            new MigrationJsonFileRepository(__DIR__.'/tmp/migrator/'),
        );

        $migrator->install(BlogMigration::class);
        
        $this->assertSame(
            [BlogMigration::class],
            $migrator->getInstalled()
        );
        
        $migrator->install(ShopMigration::class);
        
        $this->assertSame(
            [BlogMigration::class, ShopMigration::class],
            $migrator->getInstalled()
        );
        
        $migrator->uninstall(BlogMigration::class);
        $migrator->uninstall(ShopMigration::class);
        
        $this->assertSame(
            [],
            $migrator->getInstalled()
        );        
    }
    
    public function testGetInstalledMethodByNamespace()
    {
        $migrator = new Migrator(
            new AutowiringMigrationFactory(new Container()),
            new MigrationJsonFileRepository(__DIR__.'/tmp/migrator/'),
        );

        $migrator->install(BlogMigration::class);
        $migrator->install(ShopMigration::class);
        
        $this->assertSame(
            [BlogMigration::class, ShopMigration::class],
            $migrator->getInstalled('Tobento\Service\Migration\Test\Mock')
        );
        
        $this->assertSame(
            [],
            $migrator->getInstalled('Tobento\Service\Migration\Test\Mock\Action')
        );        
        
        $migrator->uninstall(BlogMigration::class);
        $migrator->uninstall(ShopMigration::class);
    }
    
    public function testIsInstalledMethod()
    {
        $migrator = new Migrator(
            new AutowiringMigrationFactory(new Container()),
            new MigrationJsonFileRepository(__DIR__.'/tmp/migrator/'),
        );

        $migrator->install(BlogMigration::class);
        
        $this->assertTrue(
            $migrator->isInstalled(BlogMigration::class)
        );
        
        $this->assertFalse(
            $migrator->isInstalled(ShopMigration::class)
        );        
        
        $migrator->uninstall(BlogMigration::class);
    }     
}