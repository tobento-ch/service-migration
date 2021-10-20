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

namespace Tobento\Service\Migration\Test\Mock;

use Tobento\Service\Migration\MigrationInterface;
use Tobento\Service\Migration\ActionsInterface;
use Tobento\Service\Migration\Actions;
use Tobento\Service\Migration\Test\Mock\Action;

/**
 * ShopMigration
 */
class ShopMigration implements MigrationInterface
{
    /**
     * Return a description of the migration.
     *
     * @return string
     */    
    public function description(): string
    {
        return 'Shop migration.';
    }
        
    /**
     * Return the actions to be processed on install.
     *
     * @return ActionsInterface
     */    
    public function install(): ActionsInterface
    {            
        return new Actions(
            new Action('config install'),
            new Action('views install'),
        );
    }

    /**
     * Return the actions to be processed on uninstall.
     *
     * @return ActionsInterface
     */    
    public function uninstall(): ActionsInterface
    {
        return new Actions(
            new Action('config uninstall'),
            new Action('views uninstall'),
        );
    }
}