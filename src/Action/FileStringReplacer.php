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
use Tobento\Service\Filesystem\File;

/**
 * Replaces the specified strings from the file.
 */
class FileStringReplacer implements ActionInterface
{    
    /**
     * Create a new FileStringReplacer.
     *
     * @param string $file The file to replace strings.
     * @param array $replace
     * @param string $description A description of the action.
     */
    public function __construct(
        protected string $file,
        protected array $replace,
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
        $file = new File($this->file);
        
        if ($file->isFile())
        {
            $search = array_keys($this->replace);
            $replace = array_values($this->replace);
            
            file_put_contents($this->file, str_replace(
                $search, $replace, $file->getContent()
            ));
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
     * Get the file.
     *
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * Get the replace.
     *
     * @return array
     */
    public function getReplace(): array
    {
        return $this->replace;
    }
}