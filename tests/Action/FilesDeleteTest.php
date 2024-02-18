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
use Tobento\Service\Migration\Action\FilesDelete;
use Tobento\Service\Migration\ActionInterface;
use Tobento\Service\Migration\ActionFailedException;
use Tobento\Service\Filesystem\Dir;
use Tobento\Service\Filesystem\File;

/**
 * FilesDeleteTest tests
 */
class FilesDeleteTest extends TestCase
{
    public function testIsInstanceofActionInterface()
    {
        $action = new FilesDelete(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    'blog.php',
                ],
            ], 
            description: 'Blog configuration files uninstalled.',
        );
        
        $this->assertInstanceOf(
            ActionInterface::class,
            $action
        );        
    }
    
    public function testProcessMethod()
    {
        $file = new File(__DIR__.'/../src/config/blog.php');
        $copiedFile = $file->copy(__DIR__.'/../src-tmp/config/blog.php');
            
        $action = new FilesDelete(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    'blog.php',
                ],
            ], 
            description: 'Blog configuration files uninstalled.',
        );
        
        $action->process();
        
        $this->assertFalse(
            $copiedFile->isFile()
        );
    }
    
    public function testProcessMethodShouldNotThrowExceptionIfFileToDeleteDoesNotExist()
    {     
        $action = new FilesDelete(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    'blog-not-exist.php',
                ],
            ], 
            description: 'Blog configuration files uninstalled.',
        );
        
        $action->process();
        
        $this->assertSame(
            [
                __DIR__.'/../src-tmp/config/blog-not-exist.php',
            ],
            $action->getDeletedFiles()
        );
    }
    
    public function testNameMethod()
    {
        $action = new FilesDelete(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    'blog.php',
                ],
            ], 
        );
        
        $this->assertSame(FilesDelete::class, $action->name());
        
        $action = new FilesDelete(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    'blog.php',
                ],
            ], 
            name: 'foo',
        );
        
        $this->assertSame('foo', $action->name());        
    }
    
    public function testDescriptionMethod()
    {
        $action = new FilesDelete(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    'blog.php',
                ],
            ], 
            description: 'Blog configuration files uninstalled.',
        );
        
        $this->assertSame(
            'Blog configuration files uninstalled.',
            $action->description()
        );
    }
    
    public function testTypeMethod()
    {
        $action = new FilesDelete(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    'blog.php',
                ],
            ], 
            type: 'foo',
        );
        
        $this->assertSame(
            'foo',
            $action->type()
        );
    }
    
    public function testProcessedDataInfoMethod()
    {
        $file = new File(__DIR__.'/../src/config/blog.php');
        $copiedFile = $file->copy(__DIR__.'/../src-tmp/config/blog.php');
        
        $action = new FilesDelete(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    'blog.php',
                ],
            ],
        );
        
        $action->process();
        
        $this->assertSame(
            [
                __DIR__.'/../src-tmp/config/blog.php',
            ],
            $action->processedDataInfo()
        );
    }
    
    public function testGetFilesMethod()
    {
        $action = new FilesDelete(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    'blog.php',
                ],
            ], 
            description: 'Blog configuration files uninstalled.',
        );
        
        $this->assertSame(
            [
                __DIR__.'/../src-tmp/config/' => [
                    'blog.php',
                ],
            ],
            $action->getFiles()
        );
    }
    
    public function testGetDeletedFilesMethod()
    {
        $file = new File(__DIR__.'/../src/config/blog.php');
        $copiedFile = $file->copy(__DIR__.'/../src-tmp/config/blog.php');
        
        $action = new FilesDelete(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    'blog.php',
                ],
            ], 
            description: 'Blog configuration files uninstalled.',
        );
        
        $action->process();
        
        $this->assertSame(
            [
                __DIR__.'/../src-tmp/config/blog.php',
            ],
            $action->getDeletedFiles()
        );
    }
}