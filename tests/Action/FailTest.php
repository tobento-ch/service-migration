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
use Tobento\Service\Migration\Action\Fail;
use Tobento\Service\Migration\ActionInterface;
use Tobento\Service\Migration\ActionFailedException;

/**
 * FailTest
 */
class FailTest extends TestCase
{
    public function testIsInstanceofActionInterface()
    {
        $this->assertInstanceOf(
            ActionInterface::class,
            new Fail('')
        );
    }
    
    public function testProcessMethod()
    {
        $this->expectException(ActionFailedException::class);
        
        $action = new Fail('');
        
        $action->process();
    }

    public function testNameMethod()
    {
        $this->assertSame(Fail::class, (new Fail(''))->name());
        
        $this->assertSame('foo', (new Fail('', name: 'foo'))->name());
    }
    
    public function testDescriptionMethod()
    {
        $this->assertSame('', (new Fail(''))->description());
        
        $this->assertSame('foo', (new Fail('', description: 'foo'))->description());
    }
    
    public function testProcessedDataInfoMethod()
    {
        $action = new Fail('');
        
        try {
            $action->process();
        } catch (ActionFailedException $e) {
            //
        }
        
        $this->assertSame([], $action->processedDataInfo());
    }
    
    public function testFailMessage()
    {
        $action = new Fail('fail message');
        $message = '';
        
        try {
            $action->process();
        } catch (ActionFailedException $e) {
            $message = $e->getMessage();
        }
        
        $this->assertSame('fail message', $message);
    }
}