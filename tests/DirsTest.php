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
use Tobento\Service\Migration\Dirs;
use Tobento\Service\Migration\DirsInterface;
use Tobento\Service\Migration\DirNotFoundException;

/**
 * DirsTest tests
 */
class DirsTest extends TestCase
{
    public function testIsInstanceofDirsInterface()
    {
        $this->assertInstanceOf(
            DirsInterface::class,
            new Dirs()
        );       
    }
    
    public function testAllMethod()
    {
        $dirs = new Dirs([
            'config' => __DIR__.'/../src/config/',
            'views' => __DIR__.'/../src/views/',
        ]);
        
        $this->assertSame(
            [
                'config' => __DIR__.'/../src/config/',
                'views' => __DIR__.'/../src/views/',
            ],
            $dirs->all()
        );       
    }
    
    public function testAddMethod()
    {
        $dirs = new Dirs();
        $dirs->add('config', __DIR__.'/../src/config/');
        $dirs->add('views', __DIR__.'/../src/views/');
        
        $this->assertSame(
            [
                'config' => __DIR__.'/../src/config/',
                'views' => __DIR__.'/../src/views/',
            ],
            $dirs->all()
        );       
    }
    
    public function testAddMethodOverwritesIfSameKeyIsset()
    {
        $dirs = new Dirs();
        $dirs->add('config', __DIR__.'/../src/config/');
        $dirs->add('config', __DIR__.'/../src/config/new/');
        
        $this->assertSame(
            [
                'config' => __DIR__.'/../src/config/new/',
            ],
            $dirs->all()
        );       
    }
    
    public function testGetMethod()
    {
        $dirs = new Dirs();
        $dirs->add('config', __DIR__.'/../src/config/');
        
        $this->assertSame(
            __DIR__.'/../src/config/',
            $dirs->get('config')
        );       
    }
    
    public function testGetMethodThrowsDirNotFoundException()
    {
        $this->expectException(DirNotFoundException::class);
        
        $dirs = new Dirs();
        $dirs->get('config');    
    }    
}