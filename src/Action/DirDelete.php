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
     * @param string $description A description of the action.
     */    
    public function __construct(
        protected string $dir,
        protected string $description = '',
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
     * Returns a description of the action.
     *
     * @return string
     */    
    public function description(): string
    {
        return $this->description;
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