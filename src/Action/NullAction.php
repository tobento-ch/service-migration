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

namespace Tobento\Service\Migration\Action;

use Tobento\Service\Migration\ActionInterface;
use Tobento\Service\Migration\ActionFailedException;

/**
 * NullAction
 */
class NullAction implements ActionInterface
{
    /**
     * Create a new instance.
     *
     * @param null|string $name A name of the action.
     * @param string $description A description of the action.
     * @param string $type A type of the action.
     */
    public function __construct(
        protected null|string $name = null,
        protected string $description = '',
        protected string $type = '',
    ) {}
        
    /**
     * Process the action.
     *
     * @return void
     * @throws ActionFailedException
     */
    public function process(): void
    {
        //
    }
    
    /**
     * Returns a name of the action.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name ?: $this::class;
    }

    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }
    
    /**
     * Returns the type of the action.
     *
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }
    
    /**
     * Returns the processed data information.
     *
     * @return array<array-key, string>
     */
    public function processedDataInfo(): array
    {
        return [];
    }
}