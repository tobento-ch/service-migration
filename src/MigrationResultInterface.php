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
 * MigrationResultInterface
 */
interface MigrationResultInterface
{
    /**
     * Get the migration.
     *
     * @return MigrationInterface
     */    
    public function migration(): MigrationInterface;

    /**
     * Get the actions processed.
     *
     * @return ActionsInterface
     */    
    public function actions(): ActionsInterface;
}