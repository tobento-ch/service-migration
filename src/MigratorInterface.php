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
 * MigratorInterface.
 */
interface MigratorInterface
{
    /**
     * Installs the given migration.
     *
     * @param string|MigrationInterface $migration The migration class name or object.
     * @return MigrationResultInterface
     * @throws MigrationInstallException
     */    
    public function install(string|MigrationInterface $migration): MigrationResultInterface;
 
    /**
     * Uninstalls the given migration.
     *
     * @param string|MigrationInterface $migration The migration class name or object.
     * @return MigrationResultInterface
     * @throws MigrationUninstallException
     */    
    public function uninstall(string|MigrationInterface $migration): MigrationResultInterface;

    /**
     * Gets the installed migration classes
     *
     * @param null|string $namespace If set it gets those starting with the namespace.
     * @return array<int, string> The installed migration classes. [Foo::class, Bar::class]
     */    
    public function getInstalled(null|string $namespace = null): array;
    
    /**
     * Checks if a migration has been installed.
     *
     * @param string $migration The migration class name.
     * @return bool True if it is installed, otherwise false
     */    
    public function isInstalled(string $migration): bool;
}