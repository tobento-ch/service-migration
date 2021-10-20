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
use Tobento\Service\Migration\MigrationResults;
use Tobento\Service\Migration\MigrationResultsInterface;
use Tobento\Service\Migration\MigrationResult;
use Tobento\Service\Migration\Test\Mock\BlogMigration;
use Tobento\Service\Migration\Test\Mock\ShopMigration;

/**
 * MigrationResultsTest tests
 */
class MigrationResultsTest extends TestCase
{
    public function testIsInstanceofMigrationResultsInterface()
    {
        $results = new MigrationResults();
            
        $this->assertInstanceOf(
            MigrationResultsInterface::class,
            $results
        );
    }

    public function testConstructor()
    {
        $migration = new BlogMigration();
        $actions = $migration->install();
        $result = new MigrationResult($migration, $actions);
        
        $results = new MigrationResults($result);
            
        $this->assertSame(
            [
                $result,
            ],
            $results->all()
        );
    }
    
    public function testAddMethod()
    {        
        $results = new MigrationResults();
 
        $migration = new BlogMigration();
        $actions = $migration->install();
        $result = new MigrationResult($migration, $actions);
        
        $shopMigration = new ShopMigration();
        $actions = $shopMigration->install();
        $shopResult = new MigrationResult($shopMigration, $actions);        
        
        $results->add($result);
        $results->add($shopResult);
        
        $this->assertSame(
            [
                $result,
                $shopResult,
            ],
            $results->all()
        ); 
    } 
    
    public function testAllMethodReturnsEmptyIfNoResults()
    {        
        $results = new MigrationResults();
        
        $this->assertSame(
            [],
            $results->all()
        ); 
    }     
}