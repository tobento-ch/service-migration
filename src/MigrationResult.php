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
     */    
    public function __construct(
        protected MigrationInterface $migration,
        protected ActionsInterface $actions,
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
}