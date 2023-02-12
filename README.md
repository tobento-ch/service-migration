# Migration Service

The Migration Service provides a flexible way for handling migrations for PHP applications.

## Table of Contents

- [Getting started](#getting-started)
	- [Requirements](#requirements)
	- [Highlights](#highlights)
    - [Simple Example](#simple-example)
- [Documentation](#documentation)
	- [Migration](#migration)
        - [Create Migration](#create-migration)
        - [Actions](#actions)
            - [Dir Copy](#dir-copy)
            - [Dir Delete](#dir-delete)
            - [Files Copy](#files-copy)
            - [Files Delete](#files-delete)
            - [File String Replacer](#file-string-replacer)
            - [PDO Exec](#pdo-exec)
        - [Custom Actions](#custom-actions)
        - [Process Actions](#process-actions)
    - [Migrator](#migrator)
        - [Create Migrator](#create-migrator)
        - [Install Migration](#install-migration)
        - [Uninstall Migration](#uninstall-migration)
        - [Get Installed Migrations](#get-installed-migrations)
        - [Migration Result](#migration-result)
        - [Migration Results](#migration-results)
- [Credits](#credits)
___

# Getting started

Add the latest version of the Migration service project running this command.

```
composer require tobento/service-migration
```

## Requirements

- PHP 8.0 or greater

## Highlights

- Framework-agnostic, will work with any project
- Decoupled design

## Simple Example

**Create a migration**

```php
namespace App\Blog;

use Tobento\Service\Migration\MigrationInterface;
use Tobento\Service\Migration\ActionsInterface;
use Tobento\Service\Migration\Actions;
use Tobento\Service\Migration\Action\FilesCopy;
use Tobento\Service\Migration\Action\FilesDelete;
use Tobento\Service\Migration\Action\DirCopy;
use Tobento\Service\Migration\Action\DirDelete;

/**
 * BlogMigration
 */
class BlogMigration implements MigrationInterface
{
    /**
     * Return a description of the migration.
     *
     * @return string
     */    
    public function description(): string
    {
        return 'Blog migration.';
    }
        
    /**
     * Return the actions to be processed on install.
     *
     * @return ActionsInterface
     */    
    public function install(): ActionsInterface
    {            
        return new Actions(
            new FilesCopy(
                files: [
                    'dir/to/store/config/' => [
                        'dir/blog/config/blog.php',
                    ],         
                ], 
                description: 'Blog configuration files installed.',
            ),           
            new DirCopy(
                dir: 'dir/blog/views/',
                destDir: 'dir/to/store/views/blog/',
                description: 'Blog view files installed.',
            ),
        );
    }

    /**
     * Return the actions to be processed on uninstall.
     *
     * @return ActionsInterface
     */    
    public function uninstall(): ActionsInterface
    {
        return new Actions(
            new FilesDelete(
                files: [
                    'dir/to/store/config/' => [
                        'blog.php',
                    ],
                ],
                description: 'Blog configuration files uninstalled.',
            ),
            new DirDelete(
                dir: 'dir/to/store/views/blog/',
                description: 'Blog view files uninstalled.',
            ),            
        );
    }
}
```

**Install / Uninstall migration**

```php
use Tobento\Service\Migration\Migrator;
use Tobento\Service\Migration\AutowiringMigrationFactory;
use Tobento\Service\Migration\MigrationJsonFileRepository;
use Tobento\Service\Migration\MigrationInstallException;
use Tobento\Service\Migration\MigrationUninstallException;
use Tobento\Service\Container\Container;

// Any PSR-11 container
$container = new Container();

// Create migrator.
$migrator = new Migrator(
    new AutowiringMigrationFactory($container),
    new MigrationJsonFileRepository(__DIR__.'/migrations/'),
);

// Install a migration.
try {
    $result = $migrator->install(\App\Blog\BlogMigration::class);
} catch (MigrationInstallException $e) {
    // Handle exception.
}

// Uninstall a migration.
if ($migrator->isInstalled(\App\Blog\BlogMigration::class))
{
    try {
        $result = $migrator->uninstall(\App\Blog\BlogMigration::class);
    } catch (MigrationUninstallException $e) {
        // Handle exception.
    } 
}
```

# Documentation

## Migration

### Create Migration

Your migration class must implement the MigrationInterface:

```php
use Tobento\Service\Migration\MigrationInterface;
use Tobento\Service\Migration\ActionsInterface;
use Tobento\Service\Migration\Actions;
use Tobento\Service\Migration\Action\FilesCopy;
use Tobento\Service\Migration\Action\FilesDelete;
use Tobento\Service\Migration\Action\DirCopy;
use Tobento\Service\Migration\Action\DirDelete;

/**
 * BlogMigration
 */
class BlogMigration implements MigrationInterface
{
    /**
     * Return a description of the migration.
     *
     * @return string
     */    
    public function description(): string
    {
        return 'Blog migration.';
    }
        
    /**
     * Return the actions to be processed on install.
     *
     * @return ActionsInterface
     */    
    public function install(): ActionsInterface
    {            
        return new Actions(
            new FilesCopy(
                files: [
                    'dir/to/store/config/' => [
                        'dir/blog/config/blog.php',
                    ],         
                ], 
                description: 'Blog configuration files installed.',
            ),           
            new DirCopy(
                dir: 'dir/blog/views/',
                destDir: 'dir/to/store/views/blog/',
                description: 'Blog view files installed.',
            ),
        );
    }

    /**
     * Return the actions to be processed on uninstall.
     *
     * @return ActionsInterface
     */    
    public function uninstall(): ActionsInterface
    {
        return new Actions(
            new FilesDelete(
                files: [
                    'dir/to/store/config/' => [
                        'blog.php',
                    ],
                ],
                description: 'Blog configuration files uninstalled.',
            ),
            new DirDelete(
                dir: 'dir/to/store/views/blog/',
                description: 'Blog view files uninstalled.',
            ),            
        );
    }
}
```

### Actions

### Dir Copy

Use the DirCopy::class action to copy a directory to another destination.

```php
use Tobento\Service\Migration\Action\DirCopy;

$action = new DirCopy(
    dir: 'dir/blog/views/',
    destDir: 'dir/to/store/views/blog/',
    name: 'A unique name', // or null
    description: 'Blog view files installed.',
);

var_dump($action->getDir());
// string(15) "dir/blog/views/"

var_dump($action->getDestDir());
// string(24) "dir/to/store/views/blog/"

var_dump($action->description());
// string(26) "Blog view files installed."
```

### Dir Delete

Use the DirDelete::class action to delete a directory.

```php
use Tobento\Service\Migration\Action\DirDelete;

$action = new DirDelete(
    dir: 'dir/to/store/views/blog/',
    name: 'A unique name', // or null
    description: 'Blog view files uninstalled.',
);

var_dump($action->getDir());
// string(24) "dir/to/store/views/blog/"

var_dump($action->description());
// string(28) "Blog view files uninstalled."
```

### Files Copy

Use the FilesCopy::class action to copy files to another directory.

```php
use Tobento\Service\Migration\Action\FilesCopy;

$action = new FilesCopy(
    files: [
        'dir/to/store/config/' => [
            'dir/blog/config/blog.php',
        ],         
    ],
    name: 'A unique name', // or null
    description: 'Blog configuration files installed.',
);

var_dump($action->getFiles());
// array(1) { ["dir/to/store/config/"]=> array(1) { [0]=> string(24) "dir/blog/config/blog.php" } }

// only available after processing the action.
var_dump($action->getCopiedFiles());
// array(0) { }

var_dump($action->description());
// string(35) "Blog configuration files installed."
```

### Files Delete

Use the FilesDelete::class action to delete files.

```php
use Tobento\Service\Migration\Action\FilesDelete;

$action = new FilesDelete(
    files: [
        'dir/to/store/config/' => [
            'blog.php',
        ],
    ],
    name: 'A unique name', // or null
    description: 'Blog configuration files uninstalled.',
);
            
var_dump($action->getFiles());
// array(1) { ["dir/to/store/config/"]=> array(1) { [0]=> string(8) "blog.php" } }

// only available after processing the action.
var_dump($action->getDeletedFiles());
// array(0) { }

var_dump($action->description());
// string(37) "Blog configuration files uninstalled."
```

### File String Replacer

Use the FileStringReplacer::class to replace strings from a file.

```php
use Tobento\Service\Migration\Action\FileStringReplacer;

$action = new FileStringReplacer(
    file: 'dir/config/http.php',
    replace: [
        '{key1}' => 'value1',
        '{key2}' => 'value2',
    ],
    name: 'A unique name', // or null
    description: 'Strings replaced.',
);
            
var_dump($action->getFile());
// string(19) "dir/config/http.php"

var_dump($action->getReplace());
// array(2) { ["{key1}"]=> string(6) "value1" ["{key2}"]=> string(6) "value2" }

var_dump($action->description());
// string(17) "Strings replaced."
```

### PDO Exec

Use the PdoExec::class to execute pdo statements.

```php
use Tobento\Service\Migration\Action\PdoExec;

$action = new PdoExec(
    pdo: $pdo,
    statements: [
        "CREATE TABLE IF NOT EXISTS blog (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            active tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci AUTO_INCREMENT=0",        
    ],
    name: 'A unique name', // or null
    description: 'Blog database tables installed.',
);
            
var_dump($action->getStatements());
// array

var_dump($action->description());
// string(31) "Blog database tables installed."
```

### Custom Actions

Below is an example of writing a custom action.

```php
use Tobento\Service\Migration\ActionInterface;
use Tobento\Service\Migration\ActionFailedException;

class CustomAction implements ActionInterface
{        
    /**
     * Process the action.
     *
     * @return void
     * @throws ActionFailedException
     */    
    public function process(): void
    {
        // process the action
    }
    
    /**
     * Returns a name of the action.
     *
     * @return string
     */
    public function name(): string
    {
        return $this::class;
    }

    /**
     * Returns a description of the action.
     *
     * @return string
     */    
    public function description(): string
    {
        return 'Action Description';
    }
    
    /**
     * Returns the processed data information.
     *
     * @return array<array-key, string>
     */
    public function processedDataInfo(): array
    {
        return [];
    }
}
```

### Process Actions

You might process an action without using the migrator.

```php
use Tobento\Service\Migration\Action\DirCopy;
use Tobento\Service\Migration\ActionFailedException;

$action = new DirCopy(
    dir: 'dir/blog/views/',
    destDir: 'dir/to/store/views/blog/',
    description: 'Blog view files installed.',
);

try {
    $action->process();
} catch (ActionFailedException $e) {
    // Handle exception.
}
```

## Migrator

### Create Migrator

```php
use Tobento\Service\Migration\Migrator;
use Tobento\Service\Migration\MigratorInterface;
use Tobento\Service\Migration\AutowiringMigrationFactory;
use Tobento\Service\Migration\MigrationJsonFileRepository;
use Tobento\Service\Container\Container;

// Any PSR-11 container
$container = new Container();

// Create migrator.
$migrator = new Migrator(
    new AutowiringMigrationFactory($container),
    new MigrationJsonFileRepository('private/dir/migrations/'),
);

var_dump($migrator instanceof MigratorInterface);
// bool(true)
```

### Install Migration

```php
use Tobento\Service\Migration\MigrationResultInterface;
use Tobento\Service\Migration\MigrationInstallException;

try {
    $result = $migrator->install(AnyMigration::class);
    
    var_dump($result instanceof MigrationResultInterface);
    // bool(true)
        
} catch (MigrationInstallException $e) {
    // Handle exception.
}
```

You might want to uninstall if the install has failed.

```php
use Tobento\Service\Migration\MigrationResultInterface;
use Tobento\Service\Migration\MigrationInstallException;
use Tobento\Service\Migration\MigrationUninstallException;

try {
    $result = $migrator->install(AnyMigration::class);        
} catch (MigrationInstallException $e) {
    try {
        $result = $migrator->uninstall(AnyMigration::class);
    } catch (MigrationUninstallException $e) {
        // Handle exception.
    }
}
```

### Uninstall Migration

```php
use Tobento\Service\Migration\MigrationResultInterface;
use Tobento\Service\Migration\MigrationUninstallException;

try {
    $result = $migrator->uninstall(AnyMigration::class);

    var_dump($result instanceof MigrationResultInterface);
    // bool(true)

} catch (MigrationUninstallException $e) {
    // Handle exception.
}
```

You might want to uninstall only if the migration has been installed before.

```php
use Tobento\Service\Migration\MigrationResultInterface;
use Tobento\Service\Migration\MigrationUninstallException;

if ($migrator->isInstalled(\App\Blog\AnyMigration::class))
{
    try {
        $result = $migrator->uninstall(AnyMigration::class);
    } catch (MigrationUninstallException $e) {
        // Handle exception.
    }
}
```

### Get Installed Migrations

```php
$migrations = $migrator->getInstalled();

// get only from specific.
$migrations = $migrator->getInstalled(namespace: 'App\Blog\');
```

### Migration Result

The migrator install and uninstall method returns the migration result object on success:

```php
use Tobento\Service\Migration\MigrationResultInterface;
use Tobento\Service\Migration\MigrationInterface;

$result = $migrator->install(AnyMigration::class);
var_dump($result instanceof MigrationResultInterface);
// bool(true)

$result = $migrator->uninstall(AnyMigration::class);
var_dump($result instanceof MigrationResultInterface);
// bool(true)
```

**Get the migration processed**

```php
use Tobento\Service\Migration\MigrationInterface;

// Get the migration processed:
var_dump($result->migration() instanceof MigrationInterface);
// bool(true)
```

**Get the migration actions processed**

```php
use Tobento\Service\Migration\ActionsInterface;

// Get the migration actions processed:
var_dump($result->actions() instanceof ActionsInterface);
// bool(true)

// You might want to iterate over the actions.
foreach($result->actions() as $action)
{
    $description = $action->description();
}
```

### Migration Results

You might want to store your results as to get it later to show the migrations processed.

```php
use Tobento\Service\Migration\Migrator;
use Tobento\Service\Migration\MigratorInterface;
use Tobento\Service\Migration\AutowiringMigrationFactory;
use Tobento\Service\Migration\MigrationJsonFileRepository;
use Tobento\Service\Migration\MigrationInstallException;
use Tobento\Service\Migration\MigrationResults;
use Tobento\Service\Migration\MigrationResultsInterface;
use Tobento\Service\Migration\MigrationResults;
use Tobento\Service\Container\Container;

// Any PSR-11 container
$container = new Container();

// Create migrator.
$migrator = new Migrator(
    new AutowiringMigrationFactory($container),
    new MigrationJsonFileRepository('private/dir/migrations/'),
);

// MigrationResults implementation.
$container->set(MigrationResultsInterface::class, function() {
    return new MigrationResults();
});

try {
    $result = $migrator->install(AnyMigration::class);
    
    // Add result.
    $container->get(MigrationResultsInterface::class)->add($result);

} catch (MigrationInstallException $e) {
    // Handle exception.
}

// Somewhere later, do something with the results.
$results = $container->get(MigrationResultsInterface::class)->all();
```

# Credits

- [Tobias Strub](https://www.tobento.ch)
- [All Contributors](../../contributors)