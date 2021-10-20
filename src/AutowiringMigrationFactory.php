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

use Psr\Container\ContainerInterface;
use Tobento\Service\Autowire\Autowire;
use Tobento\Service\Autowire\AutowireException;

/**
 * AutowiringMigrationFactory
 */
class AutowiringMigrationFactory implements MigrationFactoryInterface
{
    /**
     * @var Autowire
     */
    private Autowire $autowire;
    
    /**
     * Create a new AutowiringMigrationFactory
     *
     * @param ContainerInterface $container
     */    
    public function __construct(
        ContainerInterface $container
    ) {
        $this->autowire = new Autowire($container);
    }

    /**
     * Create a new Migration
     *
     * @param string $migration A migration class name.
     * @return MigrationInterface
     * @throws InvalidMigrationException
     */
    public function createMigration(string $migration): MigrationInterface
    {
        try {
            $migration = $this->autowire->resolve($migration);
        } catch (AutowireException $e) {
            throw new InvalidMigrationException($migration, $e->getMessage());
        }
        
        if (! $migration instanceof MigrationInterface)
        {
            throw new InvalidMigrationException(
                $migration::class,
                'Migration needs to be an instance of '.MigrationInterface::class
            );
        }
        
        return $migration;
    }
}