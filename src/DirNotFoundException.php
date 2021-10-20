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
 * DirNotFoundException
 */
class DirNotFoundException extends Exception
{
    /**
     * Create a new DirNotFoundException
     *
     * @param string $dir The directory key
     * @param string $message The message
     * @param int $code
     * @param null|Throwable $previous
     */
    public function __construct(
        protected string $dir,
        string $message = '',
        int $code = 0,
        null|Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * Get the directory key.
     *
     * @return string
     */
    public function dir(): string
    {
        return $this->dir;
    }    
}