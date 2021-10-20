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

namespace Tobento\Service\Migration\Test\Action;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Migration\Action\DirDelete;
use Tobento\Service\Migration\ActionInterface;
use Tobento\Service\Migration\ActionFailedException;
use Tobento\Service\Filesystem\Dir;

/**
 * DirDeleteTest tests
 */
class DirDeleteTest extends TestCase
{
    public function testIsInstanceofActionInterface()
    {            
        $action = new DirDelete(
            dir: __DIR__.'/../src/dir-to-delete/',
            description: 'Dir uninstalled.'
        );
        
        $this->assertInstanceOf(
            ActionInterface::class,
            $action
        );        
    }
    
    public function testProcessMethod()
    {
        $dir = new Dir();
        $dir->create(__DIR__.'/../src/dir-to-delete/');

        $this->assertTrue(
            $dir->has(__DIR__.'/../src/dir-to-delete/')
        );
        
        $action = new DirDelete(
            dir: __DIR__.'/../src/dir-to-delete/',
            description: 'Dir uninstalled.'
        );
        
        $action->process();
        
        $this->assertFalse(
            $dir->has(__DIR__.'/../src/dir-to-delete/')
        );
    }
    
    public function testDescriptionMethod()
    {
        $action = new DirDelete(
            dir: __DIR__.'/../src/dir-to-delete/',
            description: 'Dir uninstalled.'
        );
        
        $this->assertSame(
            'Dir uninstalled.',
            $action->description()
        );
    }    
    
    public function testGetDirMethod()
    {
        $action = new DirDelete(
            dir: __DIR__.'/../src/dir-to-delete/',
            description: 'Dir uninstalled.'
        );
        
        $this->assertSame(
            __DIR__.'/../src/dir-to-delete/',
            $action->getDir()
        );
    }   
}