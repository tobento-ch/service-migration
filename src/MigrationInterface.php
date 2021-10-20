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

namespace Tobento\Service\Migration;

/**
 * Interface for the migration.
 */
interface MigrationInterface
{    
    /**
     * Return the actions to be processed on install.
     *
     * @return ActionsInterface
     */    
    public function install(): ActionsInterface;

    /**
     * Return the actions to be processed on uninstall.
     *
     * @return ActionsInterface
     */    
    public function uninstall(): ActionsInterface;
    
    /**
     * Return a description of the migration.
     *
     * @return string
     */    
    public function description(): string;
}