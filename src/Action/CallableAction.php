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
 * CallableAction
 */
class CallableAction implements ActionInterface
{
    /**
     * @var callable
     */
    protected $callable;
    
    /**
     * Create a new instance.
     *
     * @param callable $callable
     * @param array $parameters Any parameters passed to the callable.
     * @param null|string $name A name of the action.
     * @param string $description A description of the action.
     * @param string $type A type of the action.
     */
    public function __construct(
        callable $callable,
        protected array $parameters = [],
        protected null|string $name = null,
        protected string $description = '',
        protected string $type = '',
    ) {
        $this->callable = $callable;
    }
        
    /**
     * Process the action.
     *
     * @return void
     * @throws ActionFailedException
     */
    public function process(): void
    {
        call_user_func_array($this->getCallable(), $this->getParameters());
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
    
    /**
     * Returns the callable.
     *
     * @return callable
     */    
    public function getCallable(): callable
    {
        return $this->callable; 
    }
    
    /**
     * Returns the parameters.
     *
     * @return array
     */    
    public function getParameters(): array
    {
        return $this->parameters; 
    }
}