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
 * ActionInterface.
 */
interface ActionInterface
{
    /**
     * Process the action.
     *
     * @return void
     * @throws ActionFailedException
     */
    public function process(): void;

    /**
     * Returns a name of the action.
     *
     * @return string
     */
    public function name(): string;
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string;
    
    /**
     * Returns the type of the action.
     *
     * @return string
     */
    public function type(): string;
    
    /**
     * Returns the processed data information.
     *
     * @return array<array-key, string>
     */
    public function processedDataInfo(): array;
}