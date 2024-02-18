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
use Tobento\Service\Migration\Action\NullAction;
use Tobento\Service\Migration\ActionInterface;
use Tobento\Service\Migration\ActionFailedException;

/**
 * NullActionTest
 */
class NullActionTest extends TestCase
{
    public function testIsInstanceofActionInterface()
    {
        $this->assertInstanceOf(
            ActionInterface::class,
            new NullAction()
        );
    }
    
    public function testProcessMethod()
    {
        $action = new NullAction();
        
        $action->process();

        $this->assertTrue(true);
    }

    public function testNameMethod()
    {
        $this->assertSame(NullAction::class, (new NullAction())->name());
        
        $this->assertSame('foo', (new NullAction(name: 'foo'))->name());
    }
    
    public function testDescriptionMethod()
    {
        $this->assertSame('', (new NullAction())->description());
        
        $this->assertSame('foo', (new NullAction(description: 'foo'))->description());
    }
    
    public function testTypeMethod()
    {
        $this->assertSame('', (new NullAction())->type());
        
        $this->assertSame('foo', (new NullAction(type: 'foo'))->type());
    }
    
    public function testProcessedDataInfoMethod()
    {
        $action = new NullAction();
        $action->process();
        
        $this->assertSame([], $action->processedDataInfo());
    }
}