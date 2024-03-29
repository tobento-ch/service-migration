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
use Tobento\Service\Migration\Action\FilesCopy;
use Tobento\Service\Migration\ActionInterface;
use Tobento\Service\Migration\ActionFailedException;
use Tobento\Service\Filesystem\Dir;
use Tobento\Service\Filesystem\File;

/**
 * FilesCopyTest tests
 */
class FilesCopyTest extends TestCase
{
    public function testIsInstanceofActionInterface()
    {
        $action = new FilesCopy(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    __DIR__.'/../src/config/blog.php',
                ],
            ], 
            description: 'Blog configuration files installed.',
        );
        
        $this->assertInstanceOf(
            ActionInterface::class,
            $action
        );        
    }
    
    public function testProcessMethod()
    {
        $action = new FilesCopy(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    __DIR__.'/../src/config/blog.php',
                ],
            ], 
            description: 'Blog configuration files installed.',
        );
        
        $action->process();
        
        $file = new File(__DIR__.'/../src-tmp/config/blog.php');
        
        $this->assertTrue(
            $file->isFile()
        );
        
        $file->delete();
    }
    
    public function testProcessMethodThrowsActionFailedExceptionIfFileDoesNotExist()
    {
        $this->expectException(ActionFailedException::class);
        
        $action = new FilesCopy(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    __DIR__.'/../src/config/blog-not-exist.php',
                ],
            ], 
            description: 'Blog configuration files installed.',
        );
        
        $action->process();
    }
    
    public function testNameMethod()
    {
        $action = new FilesCopy(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    __DIR__.'/../src/config/blog-not-exist.php',
                ],
            ], 
        );
        
        $this->assertSame(FilesCopy::class, $action->name());
        
        $action = new FilesCopy(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    __DIR__.'/../src/config/blog-not-exist.php',
                ],
            ], 
            name: 'foo',
        );
        
        $this->assertSame('foo', $action->name());        
    }
    
    public function testDescriptionMethod()
    {
        $action = new FilesCopy(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    __DIR__.'/../src/config/blog-not-exist.php',
                ],
            ], 
            description: 'Blog configuration files installed.',
        );
        
        $this->assertSame(
            'Blog configuration files installed.',
            $action->description()
        );
    }
    
    public function testTypeMethod()
    {
        $action = new FilesCopy(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    __DIR__.'/../src/config/blog-not-exist.php',
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
        $action = new FilesCopy(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    __DIR__.'/../src/config/blog.php',
                ],
            ],
        );
        
        $action->process();
        
        $this->assertSame(
            [
                'copied: '.__DIR__.'/../src-tmp/config/blog.php',
            ],
            $action->processedDataInfo()
        );
    }
    
    public function testGetFilesMethod()
    {
        $action = new FilesCopy(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    __DIR__.'/../src/config/blog-not-exist.php',
                ],
            ], 
            description: 'Blog configuration files installed.',
        );
        
        $this->assertSame(
            [
                __DIR__.'/../src-tmp/config/' => [
                    __DIR__.'/../src/config/blog-not-exist.php',
                ],
            ],
            $action->getFiles()
        );
    }
    
    public function testGetCopiedFilesMethod()
    {
        $action = new FilesCopy(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    __DIR__.'/../src/config/blog.php',
                ],
            ], 
            description: 'Blog configuration files installed.',
        );
        
        $action->process();
        
        $this->assertSame(
            [
                __DIR__.'/../src-tmp/config/blog.php',
            ],
            $action->getCopiedFiles()
        );
        
        $file = new File(__DIR__.'/../src-tmp/config/blog.php');

        $file->delete();
    }
    
    public function testProcessWithoutOverwritingFiles()
    {
        $file = new File(__DIR__.'/../src/config/blog.php');
        $file->copy(__DIR__.'/../src-tmp/config/blog.php');
        
        $action = new FilesCopy(
            files: [
                __DIR__.'/../src-tmp/config/' => [
                    __DIR__.'/../src/config/blog.php',
                ],
            ],
            overwrite: false,
        );
        
        $action->process();
        
        $this->assertSame(
            [__DIR__.'/../src/config/blog.php'],
            $action->getSkippedFiles()
        );
        
        $this->assertSame(
            ['skipped: '.__DIR__.'/../src/config/blog.php'],
            $action->processedDataInfo()
        );
        
        $file = new File(__DIR__.'/../src-tmp/config/blog.php');
        $file->delete();
    }
}