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
use Tobento\Service\Filesystem\Dir;
use Tobento\Service\Filesystem\File;

/**
 * Deletes a directory recursive.
 */
class DirDelete implements ActionInterface
{    
    /**
     * Create a new DirDelete.
     *
     * @param string $dir The directory to delete.
     * @param null|string $name A name of the action.
     * @param string $description A description of the action.
     * @param string $type A type of the action.
     */    
    public function __construct(
        protected string $dir,
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
        $dir = new Dir();
        $deleted = $dir->delete($this->dir);
        
        if (
            $deleted === false
            && $dir->has($this->dir)
        ) {
            throw new ActionFailedException(
                $this,
                'Deleting ['.$this->dir.'] failed!'
            );      
        }
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
        return [
            'dir' => $this->getDir(),
        ];
    }
    
    /**
     * Get the directory to delete.
     *
     * @return string
     */    
    public function getDir(): string
    {
        return $this->dir;
    }
}