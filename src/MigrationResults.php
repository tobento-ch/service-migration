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

use Generator;

/**
 * MigrationResults
 */
class MigrationResults implements MigrationResultsInterface
{
    /**
     * @var array<int, MigrationResultInterface>
     */    
    protected array $results = [];
    
    /**
     * Create a new MigrationResults collection.
     *
     * @param MigrationResultInterface ...$results
     */    
    public function __construct(
        MigrationResultInterface ...$results,
    ) {
        $this->results = $results;
    }

    /**
     * Add a migration result.
     *
     * @param MigrationResultInterface $result
     * @return static
     */
    public function add(MigrationResultInterface $result): static
    {
        $this->results[] = $result;
        return $this;
    }
    
    /**
     * Get all migration results.
     *
     * @return array<int, MigrationResultInterface>
     */
    public function all(): array
    {    
        return $this->results;
    }
    
    /**
     * Returns an iterator for the results.
     *
     * @return Generator
     */
    public function getIterator(): Generator
    {
        foreach($this->results as $key => $result) {
            yield $key => $result;
        }
    }
}