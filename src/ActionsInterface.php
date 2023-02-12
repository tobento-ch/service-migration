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

use IteratorAggregate;

/**
 * ActionsInterface.
 */
interface ActionsInterface extends IteratorAggregate
{
    /**
     * Add an action.
     *
     * @param ActionInterface $action
     * @return static $this
     */    
    public function add(ActionInterface $action): static;
    
    /**
     * Returns a new instance with the filtered actions.
     *
     * @param callable $callback
     * @return static
     */
    public function filter(callable $callback): static;
    
    /**
     * Returns the first action of null if none.
     *
     * @return null|ActionInterface
     */
    public function first(): null|ActionInterface;

    /**
     * If has any actions.
     *
     * @return bool True if has actions, otherwise false.
     */    
    public function empty(): bool;
    
    /**
     * Get all actions.
     *
     * @return array<int, ActionInterface>
     */    
    public function all(): array;
}