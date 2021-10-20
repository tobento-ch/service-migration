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
use Tobento\Service\Migration\ActionsProcessor;
use Tobento\Service\Migration\ActionsProcessorInterface;
use Tobento\Service\Migration\Actions;
use Tobento\Service\Migration\ActionFailedException;
use Tobento\Service\Migration\Test\Mock\Action;
use Tobento\Service\Migration\Test\Mock\FailingAction;

/**
 * ActionsProcessorTest tests
 */
class ActionsProcessorTest extends TestCase
{
    public function testIsInstanceofActionsProcessorInterface()
    {
        $this->assertInstanceOf(
            ActionsProcessorInterface::class,
            new ActionsProcessor()
        );       
    }
    
    public function testProcessMethod()
    {
        $ap = new ActionsProcessor();
        
        $actions = new Actions(
            new Action('config install'),
        );
        
        try {
            $ap->process($actions);
        } catch (ActionFailedException $e) {
            //
        }
        
        $this->assertTrue(true);    
    }
    
    public function testProcessMethodThrowsActionFailedExceptionIfAnActionFails()
    {
        $this->expectException(ActionFailedException::class);
        
        $ap = new ActionsProcessor();
        
        $actions = new Actions(
            new Action('config install'),
            new FailingAction('views install'),
        );
        
        $ap->process($actions);
    }    
}