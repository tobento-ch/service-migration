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
use Tobento\Service\Migration\MigrationResult;
use Tobento\Service\Migration\MigrationResultInterface;
use Tobento\Service\Migration\Test\Mock\BlogMigration;

/**
 * MigrationResultTest tests
 */
class MigrationResultTest extends TestCase
{
    public function testIsInstanceofMigrationResultInterface()
    {
        $migration = new BlogMigration();
        $actions = $migration->install();
        $result = new MigrationResult($migration, $actions, true);
            
        $this->assertInstanceOf(
            MigrationResultInterface::class,
            $result
        );       
    }
    
    public function testMigrationMethod()
    {
        $migration = new BlogMigration();
        $actions = $migration->install();
        $result = new MigrationResult($migration, $actions, true);
        
        $this->assertSame(
            $migration,
            $result->migration()
        );  
    }
    
    public function testActionsMethod()
    {
        $migration = new BlogMigration();
        $actions = $migration->install();
        $result = new MigrationResult($migration, $actions, true);
        
        $this->assertSame(
            $actions,
            $result->actions()
        );  
    }    
}