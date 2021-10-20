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
 * DirsInterface
 */
interface DirsInterface
{
    /**
     * Add a directory.
     *
     * @param string $key The directory key
     * @param string $dir The directory
     * @return static
     */
    public function add(string $key, string $dir): static;
    
    /**
     * Get a directory by key.
     *
     * @param string $key The directory key
     * @return string The directory
     * @throws DirNotFoundException
     */
    public function get(string $key): string;
    
    /**
     * Get all dirs.
     *
     * @return array<string, string>
     */
    public function all(): array;
}