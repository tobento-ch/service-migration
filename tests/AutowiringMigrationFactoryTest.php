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
use Tobento\Service\Migration\AutowiringMigrationFactory;
use Tobento\Service\Migration\MigrationFactoryInterface;
use Tobento\Service\Migration\MigrationInterface;
use Tobento\Service\Migration\InvalidMigrationException;
use Tobento\Service\Container\Container;
use Tobento\Service\Migration\Test\Mock\BlogMigration;

/**
 * AutowiringMigrationFactoryTest tests
 */
class AutowiringMigrationFactoryTest extends TestCase
{
    public function testIsInstanceofMigrationFactoryInterface()
    {
        $factory = new AutowiringMigrationFactory(new Container());
            
        $this->assertInstanceOf(
            MigrationFactoryInterface::class,
            $factory
        );       
    }
    
    public function testCreateMigrationMethod()
    {
        $factory = new AutowiringMigrationFactory(new Container());
        
        $migration = $factory->createMigration(BlogMigration::class);
        
        $this->assertInstanceOf(
            MigrationInterface::class,
            $migration
        );  
    }
    
    public function testThrowsInvalidMigrationExceptionIfMigrationDoesNotExist()
    {
        $this->expectException(InvalidMigrationException::class);

        $factory = new AutowiringMigrationFactory(new Container());
        
        $factory->createMigration(BlogMigrationMissing::class);        
    }    
}