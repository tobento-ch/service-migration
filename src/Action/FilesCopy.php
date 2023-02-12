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
 * Copying files to another destination.
 */
class FilesCopy implements ActionInterface
{    
    /**
     * @var array<int, string> The copied files.
     */    
    protected array $copiedFiles = [];
    
    /**
     * Create a new FilesAction.
     *
     * @param array<mixed> $files The files ['src/destination/dir/' => ['src/file.jpg']]
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
            // create dir if it does not exist.
            $destDir = rtrim($destDir, '/').'/';
            $dir = new Dir();

            if (!$dir->has($destDir))
            {
                if (!$dir->create($destDir, 0700, true))
                {
                    throw new ActionFailedException(
                        $this,
                        'Directory ['.$destDir.'] could not get created!'
                    );            
                }
            }

            // copy each file
            foreach($files as $file)
            {
                $file = new File($file);

                $destination = $destDir.$file->getBasename();
                
                $copiedFile = $file->copy($destination);
                    
                if (is_null($copiedFile))
                {
                    throw new ActionFailedException(
                        $this,
                        'Copying file ['.$file->getFile().'] to ['.$destDir.'] failed!'
                    );
                }
                
                $this->copiedFiles[] = $copiedFile->getFile();
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
        return $this->getCopiedFiles();
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
     * Get the copied files.
     *
     * @return array<int, string>
     */    
    public function getCopiedFiles(): array
    {
        return $this->copiedFiles; 
    }
}