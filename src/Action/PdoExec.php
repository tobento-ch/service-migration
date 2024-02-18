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
use PDOException;
use PDO;

/**
 * Excecuting PDO statements.
 */
class PdoExec implements ActionInterface
{    
    /**
     * Create a new PdoExec action.
     *
     * @param PDO $pdo
     * @param array<mixed> $statements
     * @param null|string $name A name of the action.
     * @param string $description A description of the action.
     * @param string $type A type of the action.
     */    
    public function __construct(
        protected PDO $pdo,
        protected array $statements,
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
        if (empty($this->statements)) {
            return;
        }
            
        try {
            $this->pdo->beginTransaction();
            
            foreach($this->statements as $statement)
            {
                $this->pdo->exec($statement);
            }
            
            if ($this->pdo->inTransaction()) {
                $this->pdo->commit();
            }
                
        } catch (PDOException $e) {
            
            if ($this->pdo->inTransaction()){
                $this->pdo->rollBack();
            }
            
            throw new ActionFailedException(
                $this,
                'PDO exec failed!',
                0,
                $e
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
        return $this->getStatements();
    }
    
    /**
     * Get the statements.
     *
     * @return array<mixed>
     */    
    public function getStatements(): array
    {
        return $this->statements;
    }
}