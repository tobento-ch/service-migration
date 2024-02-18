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
use Tobento\Service\Migration\Action\CallableAction;
use Tobento\Service\Migration\ActionInterface;
use Tobento\Service\Migration\ActionFailedException;

/**
 * CallableActionTest
 */
class CallableActionTest extends TestCase
{
    public function testIsInstanceofActionInterface()
    {
        $this->assertInstanceOf(
            ActionInterface::class,
            new CallableAction(function () {})
        );
    }
    
    public function testProcessMethod()
    {
        $action = new CallableAction(
            callable: function () {
                
            },
            parameters: [],
        );
        
        $action->process();
        
        $this->assertTrue(true);
    }

    public function testNameMethod()
    {
        $this->assertSame(CallableAction::class, (new CallableAction(function () {}))->name());
        
        $this->assertSame('foo', (new CallableAction(function () {}, name: 'foo'))->name());
    }
    
    public function testDescriptionMethod()
    {
        $this->assertSame('', (new CallableAction(function () {}))->description());
        
        $this->assertSame('foo', (new CallableAction(function () {}, description: 'foo'))->description());
    }
    
    public function testTypeMethod()
    {
        $this->assertSame('', (new CallableAction(function () {}))->type());
        
        $this->assertSame('foo', (new CallableAction(function () {}, type: 'foo'))->type());
    }
    
    public function testProcessedDataInfoMethod()
    {
        $action = new CallableAction(function () {});
        $action->process();
        
        $this->assertSame([], $action->processedDataInfo());
    }
    
    public function testGetCallableMethod()
    {
        $callable = function () {};
        
        $action = new CallableAction($callable);
        
        $this->assertSame($callable, $action->getCallable());
    }
    
    public function testGetParametersMethod()
    {
        $parameters = ['name' => 'value'];
        $action = new CallableAction(function () {}, $parameters);
        
        $this->assertSame($parameters, $action->getParameters());
    }
}