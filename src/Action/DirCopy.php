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
 * Copying directory to another destination.
 */
class DirCopy implements ActionInterface
{    
    /**
     * Create a new DirCopy.
     *
     * @param string $dir The directory to copy.
     * @param string $destDir The destination directory.
     * @param string $description A description of the action.
     */    
    public function __construct(
        protected string $dir,
        protected string $destDir,
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
        $copied = $dir->copy($this->dir, $this->destDir);
        
        if ($copied === false)
        {
            throw new ActionFailedException(
                $this,
                'Copying ['.$this->dir.'] failed!'
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
            'destDir' => $this->getDestDir(),
        ];
    }
    
    /**
     * Get the directory to copy.
     *
     * @return string
     */    
    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * Get the destination directory
     *
     * @return string
     */    
    public function getDestDir(): string
    {
        return $this->destDir; 
    }
}