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
 * MigrationResult
 */
class MigrationResult implements MigrationResultInterface
{            
    /**
     * Create a new MigrationResult.
     *
     * @param MigrationInterface $migration The migration.
     * @param ActionsInterface $actions The actions processed.
     * @param bool $installed True if installed otherwise false as uninstalled.
     */    
    public function __construct(
        protected MigrationInterface $migration,
        protected ActionsInterface $actions,
        protected bool $installed,
    ) {}

    /**
     * Get the migration.
     *
     * @return MigrationInterface
     */    
    public function migration(): MigrationInterface
    {
        return $this->migration;
    }

    /**
     * Get the actions processed.
     *
     * @return ActionsInterface
     */    
    public function actions(): ActionsInterface
    {
        return $this->actions;
    }
    
    /**
     * Returns true if installed, otherwise false (uninstalled).
     *
     * @return bool
     */
    public function installed(): bool
    {
        return $this->installed;
    }
}