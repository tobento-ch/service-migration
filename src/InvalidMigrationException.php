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

use Exception;
use Throwable;

/**
 * InvalidMigrationException
 */
class InvalidMigrationException extends Exception
{
    /**
     * Create a new InvalidMigrationException
     *
     * @param string|object $migration The migration class name or object.
     * @param string $message The message
     * @param int $code
     * @param null|Throwable $previous
     */
    public function __construct(
        protected string|object $migration,
        string $message = '',
        int $code = 0,
        null|Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * Get the migration.
     *
     * @return string|object
     */
    public function migration(): string|object
    {
        return $this->migration;
    }     
}