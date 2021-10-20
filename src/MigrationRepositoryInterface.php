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
 * MigrationRepositoryInterface
 */
interface MigrationRepositoryInterface
{
    /**
     * Returns the migrations.
     *
     * @return array<int, string> [Migration::class, ...]
     */    
    public function getMigrations(): array;
    
    /**
     * Store migration
     *
     * @param string $migration The migration class.
     * @param MigrationResultInterface $result
     * @return array<mixed> The stored data.
     */    
    public function store(string $migration, MigrationResultInterface $result): array;
    
    /**
     * Fetch migration data.
     *
     * @param string $migration The migration class.
     * @return array<mixed> Any data stored.
     */    
    public function fetch(string $migration): array; 

    /**
     * Delete migration
     *
     * @param string $migration The migration class.
     * @param MigrationResultInterface $result
     * @return array<mixed> The deleted data.
     */    
    public function delete(string $migration, MigrationResultInterface $result): array;
    
    /**
     * Delete all migrations
     *
     * @return array<mixed> The deleted data.
     */    
    public function deleteAll(): array;
}