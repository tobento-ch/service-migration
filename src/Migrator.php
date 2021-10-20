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
 * Migrator
 */
class Migrator implements MigratorInterface
{
    /**
     * @var array The installed migrations.
     */    
    protected array $installed = [];
    
    /**
     * Create a new Migrator.
     *
     * @param MigrationFactoryInterface $migrationFactory
     * @param MigrationRepositoryInterface $repository
     * @param null|ActionsProcessorInterface $actionsProcessor
     */    
    public function __construct(
        protected MigrationFactoryInterface $migrationFactory,
        protected MigrationRepositoryInterface $repository,
        protected null|ActionsProcessorInterface $actionsProcessor = null,
    ) {
        // get and set all installed migrations.
		$this->installed = $repository->getMigrations();
        
        $this->actionsProcessor = $actionsProcessor ?: new ActionsProcessor();
    }
    
    /**
     * Installs the given migration.
     *
     * @param string|MigrationInterface $migration The migration class name or object.
     * @return MigrationResultInterface
     * @throws MigrationInstallException
     */    
    public function install(string|MigrationInterface $migration): MigrationResultInterface
    {
        try {
            $migration = $this->ensureMigration($migration);
            
            $actions = $migration->install();
            
            $this->actionsProcessor()->process($actions);
            
            return $this->installed(new MigrationResult($migration, $actions));
            
        } catch (ActionFailedException $e) {

            throw new MigrationInstallException(
                $migration,
                'Migration install failed!',
                0,
                $e
            );
        }
    }
 
    /**
     * Uninstalls the given migration.
     *
     * @param string|MigrationInterface $migration The migration class name or object.
     * @return MigrationResultInterface
     * @throws MigrationUninstallException
     */    
    public function uninstall(string|MigrationInterface $migration): MigrationResultInterface
    {        
        try {
            $migration = $this->ensureMigration($migration);
            
            $actions = $migration->uninstall();
            
            $this->actionsProcessor()->process($actions);
            
            return $this->uninstalled(new MigrationResult($migration, $actions));
            
        } catch (ActionFailedException $e) {
            
            throw new MigrationUninstallException(
                $migration,
                'Migration uninstall failed!',
                0,
                $e
            );
        }
    }

    /**
     * Gets the installed migration classes
     *
     * @param null|string $namespace If set it gets those starting with the namespace.
     * @return array<int, string> The installed migration classes. [Foo::class, Bar::class]
     */    
    public function getInstalled(null|string $namespace = null): array
    {
        if (is_null($namespace))
        {
            return $this->installed;
        }
        
        return array_filter($this->installed, function($classname) use ($namespace)
        {
            return substr($classname, 0, strlen($namespace)) === $namespace;
        });        
    }
    
    /**
     * Checks if a migration has been installed.
     *
     * @param string $migration The migration class name.
     * @return bool True if it is installed, otherwise false
     */    
    public function isInstalled(string $migration): bool
    {
        return in_array($migration, $this->installed);
    }
        
    /**
     * Handles the installed migration.
     *
     * @param MigrationResultInterface $migrationResult
     * @return MigrationResultInterface
     */    
    protected function installed(MigrationResultInterface $migrationResult): MigrationResultInterface
    {
        $migration = $migrationResult->migration();
        
        $this->repository->store($migration::class, $migrationResult);
        
        // update installed.
        $this->installed = $this->repository->getMigrations();
        
        return $migrationResult;
    }
    
    /**
     * Handles the uninstalled migration.
     *
     * @param MigrationResultInterface $migrationResult
     * @return MigrationResultInterface
     */    
    protected function uninstalled(MigrationResultInterface $migrationResult): MigrationResultInterface
    {
        $migration = $migrationResult->migration();
        
        $this->repository->delete($migration::class, $migrationResult);
        
        // update installed.
        $this->installed = $this->repository->getMigrations();
        
        return $migrationResult;
    }

    /**
     * Ensures the migration
     *
     * @param string|MigrationInterface $migration The migration class name or object.
     * @return MigrationInterface
     */    
    protected function ensureMigration(string|MigrationInterface $migration): MigrationInterface
    {
        if (is_string($migration))
        {
            return $this->migrationFactory->createMigration($migration);
        }
        
        return $migration;
    }
    
    /**
     * Returns the actions processor.
     *
     * @return ActionsProcessorInterface
     */    
    protected function actionsProcessor(): ActionsProcessorInterface
    {
        if (is_null($this->actionsProcessor))
        {
            $this->actionsProcessor = new ActionsProcessor();
        }
        
        return $this->actionsProcessor;
    }    
}