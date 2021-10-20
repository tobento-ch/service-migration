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
 * ActionsProcessorInterface.
 */
interface ActionsProcessorInterface
{
    /**
     * Processes the actions.
     *
     * @param ActionsInterface $actions
     * @return void
     * @throws ActionFailedException
     */    
    public function process(ActionsInterface $actions): void;
}