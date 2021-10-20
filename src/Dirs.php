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
 * Dirs
 */
class Dirs implements DirsInterface
{
    /**
     * Create a new Dirs collection.
     *
     * @param array<string, string> $dirs The directories ['key' => www/dir/', ...]
     */    
    public function __construct(
        protected array $dirs = [],
    ) {}

    /**
     * Add a directory.
     *
     * @param string $key The directory key
     * @param string $dir The directory
     * @return static
     */
    public function add(string $key, string $dir): static
    {
        $this->dirs[$key] = $dir;
        return $this;
    }
    
    /**
     * Get a directory by key.
     *
     * @param string $key The directory key
     * @return string The directory
     * @throws DirNotFoundException
     */
    public function get(string $key): string
    {
        if (!isset($this->dirs[$key]))
        {
            throw new DirNotFoundException(
                $key,
                'Directory ['.$key.'] not found!'
            );            
        }
        
        return $this->dirs[$key];
    }
    
    /**
     * Get all dirs.
     *
     * @return array<string, string>
     */
    public function all(): array
    {    
        return $this->dirs;
    }    
}