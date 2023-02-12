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
use Tobento\Service\Migration\ActionsInterface;
use Tobento\Service\Migration\ActionInterface;
use Tobento\Service\Migration\Actions;
use Tobento\Service\Migration\Test\Mock\Action;

/**
 * ActionsTest tests
 */
class ActionsTest extends TestCase
{
    public function testIsInstanceofActionsInterface()
    {
        $this->assertInstanceOf(
            ActionsInterface::class,
            new Actions()
        );       
    }
    
    public function testAddMethod()
    {
        $actions = new Actions();
        
        $action = new Action('config install');
        
        $actions->add($action);
        
        $this->assertSame(
            $action,
            $actions->all()[0]
        );       
    }
    
    public function testFilterMethod()
    {
        $actions = new Actions(
            new Action('config'),
            new Action('db'),
        );
        
        $actionsNew = $actions->filter(
            fn(ActionInterface $a): bool => $a->name() === 'config'
        );
        
        $this->assertFalse($actions === $actionsNew);
        $this->assertSame(1, count($actionsNew->all()));
        $this->assertSame(2, count($actions->all()));
    }
    
    public function testFirstMethod()
    {
        $actions = new Actions(
            new Action('config'),
            new Action('db'),
        );
        
        $this->assertInstanceof(ActionInterface::class, $actions->first());
        
        $actions = new Actions();
        
        $this->assertSame(null, $actions->first());
    }
    
    public function testGetMethod()
    {
        $actions = new Actions(
            new Action('config'),
            new Action('db'),
        );
        
        $this->assertSame('db', $actions->get(name: 'db')?->name());
        
        $actions = new Actions();
        
        $this->assertSame(null, $actions->get(name: 'db'));
    }
    
    public function testAllMethod()
    {        
        $action = new Action('config install');
        $actionView = new Action('view install');
        
        $actions = new Actions($action, $actionView);
        
        $this->assertSame(
            [
                $action,
                $actionView,
            ],
            $actions->all()
        );       
    }
    
    public function testEmptyMethod()
    {        
        $this->assertFalse(
            (new Actions(new Action('config install')))->empty()
        );
        
        $this->assertTrue(
            (new Actions())->empty()
        );        
    }
    
    public function testIteration()
    {
        $actions = new Actions(
            new Action('config'),
            new Action('db'),
        );
        
        foreach($actions as $action) {
            $this->assertInstanceof(ActionInterface::class, $action);
        }
    }
}