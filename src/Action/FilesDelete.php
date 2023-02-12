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
 * Deleting files.
 */
class FilesDelete implements ActionInterface
{    
    /**
     * @var array<int, string> The deleted files.
     */    
    protected array $deletedFiles = [];  
    
    /**
     * Create a new FilesAction.
     *
     * @param array<mixed> $files The files ['src/destination/dir/' => ['file.jpg']]
     * @param null|string $name A name of the action.
     * @param string $description A description of the action.
     */    
    public function __construct(
        protected array $files = [],
        protected null|string $name = null,
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
        foreach($this->files as $destDir => $files)
        {
            foreach($files as $file)
            {
                $file = (new File($file))->withDirname($destDir);
                
                if (! $file->delete())
                {
                    throw new ActionFailedException(
                        $this,
                        'Deleting file ['.$file->getFile().'] failed!'
                    );
                }
                
                $this->deletedFiles[] = $file->getFile();
            }

            // if dir is empty, delete it too.
            $dir = new Dir();

            if ($dir->isEmpty($destDir))
            {
                $dir->delete($destDir);
            }
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
     * Returns the processed data information.
     *
     * @return array<array-key, string>
     */
    public function processedDataInfo(): array
    {
        return $this->getDeletedFiles();
    }
    
    /**
     * Get the files.
     *
     * @return array<mixed>
     */    
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * Get the deleted files.
     *
     * @return array<int, string>
     */    
    public function getDeletedFiles(): array
    {
        return $this->deletedFiles; 
    }
}