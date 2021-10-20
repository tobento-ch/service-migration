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
 * MigrationFactoryInterface
 */
interface MigrationFactoryInterface
{   
    /**
     * Create a new Migration
     *
     * @param string $migration A migration class.
     * @return MigrationInterface
     * @throws InvalidMigrationException
     */
    public function createMigration(string $migration): MigrationInterface;
}