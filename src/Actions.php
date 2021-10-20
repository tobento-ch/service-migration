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
 * Actions
 */
class Actions implements ActionsInterface
{
    /**
     * @var array<int, ActionInterface>
     */    
    protected array $actions = [];
    
    /**
     * Create a new Actions.
     *
     * @param ActionInterface ...$actions
     */    
    public function __construct(
        ActionInterface ...$actions
    ) {
        $this->actions = $actions;
    }
    
    /**
     * Add an action.
     *
     * @param ActionInterface $action
     * @return static $this
     */    
    public function add(ActionInterface $action): static
    {
        $this->actions[] = $action;
        return $this;
    }    

    /**
     * If has any actions.
     *
     * @return bool True if has actions, otherwise false.
     */    
    public function empty(): bool
    {
        return empty($this->actions);
    }
    
    /**
     * Get all actions.
     *
     * @return array<int, ActionInterface>
     */    
    public function all(): array
    {
        return $this->actions;
    }    
}