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
 * MigrationResultsInterface
 */
interface MigrationResultsInterface
{
    /**
     * Add a migration result.
     *
     * @param MigrationResultInterface $result
     * @return static
     */
    public function add(MigrationResultInterface $result): static;
    
    /**
     * Get all migration results.
     *
     * @return array<int, MigrationResultInterface>
     */
    public function all(): array;
}