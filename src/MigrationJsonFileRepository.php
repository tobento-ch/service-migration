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

use Tobento\Service\Filesystem\JsonFile;
use Tobento\Service\FileCreator\FileCreator;
use Tobento\Service\FileCreator\FileCreatorException;

/**
 * MigrationJsonFileRepository
 */
class MigrationJsonFileRepository implements MigrationRepositoryInterface
{
    /**
     * Create a new MigrationRepository.
     *
     * @param string $storageDir The storage dir where to store the file
     */    
    public function __construct(
        protected string $storageDir,
    ) {}
    
    /**
     * Returns the migrations.
     *
     * @return array<int, string> [Migration::class, ...]
     */    
    public function getMigrations(): array
    {
        return $this->fetchMigrations();
    }
    
    /**
     * Store migration
     *
     * @param string $migration The migration class.
     * @param MigrationResultInterface $result
     * @return array<mixed> The stored data.
     */    
    public function store(string $migration, MigrationResultInterface $result): array
    {        
        $migrations = $this->fetchMigrations();
        
        $migrations[] = $migration;
        
        $migrations = array_unique($migrations);

        try {
            (new FileCreator())
                ->content(json_encode($migrations))
                ->create($this->storageDir.'migrations.json', FileCreator::CONTENT_NEW);
        } catch (FileCreatorException $e) {
            throw $e;
        }
        
        return [
            'migration' => $migration,
        ];
    }
    
    /**
     * Fetch migration data.
     *
     * @param string $migration The migration class.
     * @return array<mixed> Any data stored.
     */    
    public function fetch(string $migration): array
    {
        return [
            'migration' => $migration,
        ];
    }    

    /**
     * Delete migration
     *
     * @param string $migration The migration class.
     * @param MigrationResultInterface $result
     * @return array<mixed> The deleted data.
     */    
    public function delete(string $migration, MigrationResultInterface $result): array
    {
        $migrations = $this->fetchMigrations();
        
        $migrations = array_diff($migrations, [$migration]);

        try {
            (new FileCreator())
                ->content(json_encode($migrations))
                ->create($this->storageDir.'migrations.json', FileCreator::CONTENT_NEW);
        } catch (FileCreatorException $e) {
            throw $e;
        }        
        
        return [
            'migration' => $migration,
        ];
    }
    
    /**
     * Delete all migrations
     *
     * @return array<mixed> The deleted data.
     */    
    public function deleteAll(): array
    {
        $migrations = $this->fetchMigrations();

        try {
            (new FileCreator())
                ->create($this->storageDir.'migrations.json', FileCreator::CONTENT_NEW);
        } catch (FileCreatorException $e) {
            throw $e;
        }        
        
        return $migrations;
    }    
    
    /**
     * Fetch the migrations data.
     *
     * @return array<int, string> [Migration::class, ...]
     */    
    protected function fetchMigrations(): array
    {
        $file = new JsonFile($this->storageDir.'migrations.json');
                
        if ($file->isFile())
        {
            return $file->toArray();
        }
                
        return [];
    }    
}