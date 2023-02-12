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
use Tobento\Service\Migration\Action\FileStringReplacer;
use Tobento\Service\Migration\ActionInterface;
use Tobento\Service\Migration\ActionFailedException;
use Tobento\Service\Filesystem\File;

/**
 * FileStringReplacerTest tests
 */
class FileStringReplacerTest extends TestCase
{
    public function testIsInstanceofActionInterface()
    {
        $action = new FileStringReplacer(
            file: __DIR__.'/../src/config/http.php',
            replace: [],
            description: 'Replacement done.',
        );
        
        $this->assertInstanceOf(
            ActionInterface::class,
            $action
        );        
    }
    
    public function testProcessMethod()
    {
        $file = new File(__DIR__.'/../src/config/http.php');
        
        $copiedFile = $file->copy(__DIR__.'/../src/replace-tmp/http.php');
        
        $action = new FileStringReplacer(
            file: $copiedFile->getFile(),
            replace: [
                '{key1}' => 'value1',
                '{key2}' => 'value2'
            ],
            description: 'Replacement done.',
        );
        
        $action->process();
        
        $content = require $copiedFile->getFile();

        $this->assertSame('value1', $content['key1']);
        $this->assertSame('value2', $content['key2']);
        
        $copiedFile->delete();
    }
    
    public function testNameMethod()
    {
        $action = new FileStringReplacer(
            file: __DIR__.'/../src/config/http.php',
            replace: [],
        );
        
        $this->assertSame(FileStringReplacer::class, $action->name());
        
        $action = new FileStringReplacer(
            file: __DIR__.'/../src/config/http.php',
            replace: [],
            name: 'foo',
        );
        
        $this->assertSame('foo', $action->name());        
    }
    
    public function testDescriptionMethod()
    {
        $action = new FileStringReplacer(
            file: __DIR__.'/../src/config/http.php',
            replace: [],
            description: 'Replacement done.',
        );
        
        $this->assertSame(
            'Replacement done.',
            $action->description()
        );
    }    
    
    public function testGetFileMethod()
    {
        $action = new FileStringReplacer(
            file: __DIR__.'/../src/config/http.php',
            replace: [],
            description: 'Replacement done.',
        );
        
        $this->assertSame(
            __DIR__.'/../src/config/http.php',
            $action->getFile()
        );
    }
    
    public function testGetReplaceMethod()
    {
        $action = new FileStringReplacer(
            file: __DIR__.'/../src/config/http.php',
            replace: [
                '{key1}' => 'value1',
                '{key2}' => 'value2',
            ],
            description: 'Replacement done.',
        );
        
        $this->assertSame(
            [
                '{key1}' => 'value1',
                '{key2}' => 'value2',
            ],
            $action->getReplace()
        );
    }
}