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
 * MigrationInstallException
 */
class MigrationInstallException extends Exception
{
    /**
     * Create a new MigrationInstallException
     *
     * @param string|MigrationInterface $migration
     * @param string $message The message
     * @param int $code
     * @param null|Throwable $previous
     */
    public function __construct(
        protected string|MigrationInterface $migration,
        string $message = '',
        int $code = 0,
        null|Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * Get the migration.
     *
     * @return string|MigrationInterface
     */
    public function migration(): string|MigrationInterface
    {
        return $this->migration;
    }     
}