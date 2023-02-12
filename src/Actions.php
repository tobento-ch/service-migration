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
     * Returns a new instance with the filtered actions.
     *
     * @param callable $callback
     * @return static
     */
    public function filter(callable $callback): static
    {
        $new = clone $this;
        $new->actions = array_filter($this->actions, $callback);
        return $new;
    }
    
    /**
     * Returns the first action of null if none.
     *
     * @return null|ActionInterface
     */
    public function first(): null|ActionInterface
    {
        $key = array_key_first($this->actions);
        
        if (is_null($key)) {
            return null;
        }
        
        return $this->actions[$key];    
    }
    
    /**
     * Returns the action by name or null if not exists.
     *
     * @param string $name
     * @return null|ActionInterface
     */
    public function get(string $name): null|ActionInterface
    {
        return $this->filter(
            fn(ActionInterface $a) => $a->name() === $name
        )->first();
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

    /**
     * Returns an iterator for the actions.
     *
     * @return Generator
     */
    public function getIterator(): Generator
    {
        foreach($this->actions as $key => $action) {
            yield $key => $action;
        }
    }
}