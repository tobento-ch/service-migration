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
 * ActionFailedException
 */
class ActionFailedException extends Exception
{
    /**
     * Create a new ActionFailedException
     *
     * @param ActionInterface $action
     * @param string $message The message
     * @param int $code 
     * @param null|Throwable $previous
     */
    public function __construct(
        protected ActionInterface $action,
        string $message = '',
        int $code = 0,
        null|Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * Get the action.
     *
     * @return ActionInterface
     */
    public function action(): ActionInterface
    {
        return $this->action;
    }     
}