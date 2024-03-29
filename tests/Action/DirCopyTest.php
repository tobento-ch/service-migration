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
use Tobento\Service\Migration\Action\DirCopy;
use Tobento\Service\Migration\ActionInterface;
use Tobento\Service\Migration\ActionFailedException;
use Tobento\Service\Filesystem\Dir;

/**
 * DirCopyTest tests
 */
class DirCopyTest extends TestCase
{
    public function testIsInstanceofActionInterface()
    {
        $action = new DirCopy(
            dir: __DIR__.'/../src/',
            destDir: __DIR__.'/../src-tmp/',
            description: 'Dir installed.',
        );
        
        $this->assertInstanceOf(
            ActionInterface::class,
            $action
        );        
    }
    
    public function testProcessMethod()
    {
        $action = new DirCopy(
            dir: __DIR__.'/../src/',
            destDir: __DIR__.'/../src-tmp/',
            description: 'Dir installed.',
        );
        
        $action->process();
        
        $dir = new Dir();

        $this->assertTrue(
            $dir->has(__DIR__.'/../src-tmp/config')
        );
        
        $dir->delete(__DIR__.'/../src-tmp/');
    }
    
    public function testProcessMethodThrowsActionFailedExceptionIfDirDoesNotExist()
    {
        $this->expectException(ActionFailedException::class);
        
        $action = new DirCopy(
            dir: __DIR__.'/../src/not-exist-folder',
            destDir: __DIR__.'/../src-tmp/',
            description: 'Dir installed.',
        );
        
        $action->process();
    }

    public function testNameMethod()
    {
        $action = new DirCopy(
            dir: __DIR__.'/../src/',
            destDir: __DIR__.'/../src-tmp/',
        );
        
        $this->assertSame(DirCopy::class, $action->name());
        
        $action = new DirCopy(
            dir: __DIR__.'/../src/',
            destDir: __DIR__.'/../src-tmp/',
            name: 'foo',
        );
        
        $this->assertSame('foo', $action->name());        
    }
    
    public function testDescriptionMethod()
    {
        $action = new DirCopy(
            dir: __DIR__.'/../src/',
            destDir: __DIR__.'/../src-tmp/',
            description: 'Dir installed.',
        );
        
        $this->assertSame(
            'Dir installed.',
            $action->description()
        );
    }
    
    public function testTypeMethod()
    {
        $action = new DirCopy(
            dir: __DIR__.'/../src/',
            destDir: __DIR__.'/../src-tmp/',
            type: 'foo',
        );
        
        $this->assertSame(
            'foo',
            $action->type()
        );
    }
    
    public function testProcessedDataInfoMethod()
    {
        $action = new DirCopy(
            dir: __DIR__.'/../src/',
            destDir: __DIR__.'/../src-tmp/',
            description: 'Dir installed.',
        );
        
        $action->process();
        
        $this->assertSame(
            [
                'dir' => __DIR__.'/../src/',
                'destDir' => __DIR__.'/../src-tmp/',
            ],
            $action->processedDataInfo()
        );
    }
    
    public function testGetDirMethod()
    {
        $action = new DirCopy(
            dir: __DIR__.'/../src/',
            destDir: __DIR__.'/../src-tmp/',
            description: 'Dir installed.',
        );
        
        $this->assertSame(
            __DIR__.'/../src/',
            $action->getDir()
        );
    }
    
    public function testGetDestDirMethod()
    {
        $action = new DirCopy(
            dir: __DIR__.'/../src/',
            destDir: __DIR__.'/../src-tmp/',
            description: 'Dir installed.',
        );
        
        $this->assertSame(
            __DIR__.'/../src-tmp/',
            $action->getDestDir()
        );
    }
}