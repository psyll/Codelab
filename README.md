# Welcome to **Codelab**


![Codelab Logo](https://raw.githubusercontent.com/psyll/Codelab/main/docs/assets/logo.png)
[![License](https://badgen.net/badge/license/PPCL)](https://psyll.com/license/ppcl-psyll-public-code-license)
![Languages count](https://img.shields.io/github/languages/count/psyll/Codelab)
![Top Language](https://img.shields.io/github/languages/top/psyll/Codelab)
![Repo Size](https://img.shields.io/github/repo-size/psyll/Codelab)
![Code Size](https://img.shields.io/github/languages/code-size/psyll/Codelab)
![Last commit](https://img.shields.io/github/last-commit/psyll/Codelab)
![Open issues](https://img.shields.io/github/issues-raw/psyll/Codelab)
[![CodeFactor](https://www.codefactor.io/repository/github/psyll/codelab/badge?s=ae31d6f3226bdf7bbf736f7337658a3f3d6a7fbd)](https://www.codefactor.io/repository/github/psyll)

[![Open in Visual Studio Code](https://open.vscode.dev/badges/open-in-vscode.svg)](https://open.vscode.dev/psyll/Codelab)

# Introduction

**Codelab** is an application designed to optimize web development processes. It contains a collection of classes and functions supporting the development of websites and web applications on every stage.

Build your **Codelab** easily with new functionalities, using ready-made packages and a simple manager.

The system provides simple and quick solutions that will help you design and code a web application faster, safer and more comfortable in a [Codelab Way](https://psyll.com/products/codelab/way).

# Additional tools

- Visual Studio Code:  [https://psyll.com/products/codelab/snippets](https://psyll.com/products/codelab/snippets).

# Installation

1) Download the latest Codelab release from the [official website](https://psyll.com/products/codelab)
2) Upload `codelab` folder your project workspace
3) Include main `cl.php` file

    ```php
    include('./codelab/cl.php');
    ```
4) Check if everything is ok. Display **Codelab** output.

    ```php
    Codelab::output();
    ```

# Packages

All packages in the `codelab/packages` folder are automatically loaded according to a hierarchy basis of dependiences,

## Packages loading management - `CL_LOAD`

To load selected packages use the `CL_LOAD` define. Using it you can define what packages will be loaded and overwrite configuration data pf each package.

This defined also allows for automatic loading of all required packages.

`CL_LOAD` must be defined before loading the cl.php file.

## Construction of the `CL_LOAD` define

The define can consists following elements - `[packages]`, `[require]` and `[config]`

 - `[packages]` - Array of selected package names
 - `[require]` - Bool `true` to load all `require` automaticly
 - `[config]` - Array of packages config overwrites



## Examples:

#### Disable all packages

```php
// It will not load any package
DEFINE('CL_LOAD', ["packages" => false]);
```

#### Load selected packages

```php
// Load only PACKAGE_NAME1 and PACKAGE_NAME2 packages
DEFINE('CL_LOAD', ["packages" => ['PACKAGE_NAME1', 'PACKAGE_NAME2']]);
```

#### Load packages with all required packages

```php
// Load packages and all required
DEFINE(
    'CL_LOAD',
    [

        "packages" => [
            'PACKAGE_NAME1',
            'PACKAGE_NAME2',
        ],
        // Auto load require
        "require" => true
	]
);
```

#### Overwrite package configuration

```php
// Overwrite package config
DEFINE(
    'CL_LOAD',
    [
        "config" => [
            'PACKAGE_NAME' => [
                'CONFIG_NAME' => "CONFIG_VALUE",
            ]
        ]
	]
);
```

#### Full example
```php
// Load packages PACKAGE_NAME1, PACKAGE_NAME2 and all required
// Overwrite PACKAGE_NAME2 package config
DEFINE(
    'CL_LOAD',
    [

        "packages" => [
            'PACKAGE_NAME1',
            'PACKAGE_NAME2',
        ],
        // Auto load require
        "require" => true,
        "config" => [
            'PACKAGE_NAME2' => [
                'CONFIG_NAME' => "CONFIG_VALUE",
            ]
        ]
	]
);
```

# Main Codelab defines

- `CL_START` - Load start in microtime
- `CL_VERSION` - Version number
- `CL_CODENAME` - Version codename
- `CL_PATH` - Codelab main folder path
- `CL_DOMAIN` - Domain name
- `CL_PROTOCOL` - Protocol `http` or `https`
- `CL_QUERY` - Current page URL query string
- `CL_URL` - Current page URL
- `CL_CONFIG` - Codelab main config
- `CL_PACKAGES` - Codelab packages list
- `CL_END` - Load end in microtime

# Built-in classes and functions

## `Codelab` class

 - `Codelab::packageConfigRead(string $packageDir)`
 - `Codelab::packageInstalled(string $packageName)`
 - `Codelab::requireAjax()`
 - `Codelab::isAjax()`
 - `Codelab::requirePost()`
 - `Codelab::isPost()`
 - `Codelab::headerStatus(int $statusCode)`;
 - `Codelab::headers(string $headerName = null)`
 - `Codelab::log(string $source, string $type, string $message)`
 - `Codelab::logs()`
 - `Codelab::output()`

## `clDB` class

 - `CodelabDB::connected()`
 - `CodelabDB::disconnect()`
 - `CodelabDB::escape(string $string)`
 - `CodelabDB::query(string $query)`
 - `CodelabDB::fetch($results)`
 - `CodelabDB::columns($table)`
 - `CodelabDB::get(array $param, $single = false)`
 - `CodelabDB::insert(string $table, array $columns)`
 - `CodelabDB::delete(string $table, $id)`
 - `CodelabDB::insertID()`
 - `CodelabDB::update(string $table, string $where, array $fields)`





# Packages list

| Function | Version || Require| Description |
|-------------|-------------|-------------|-------------|-------------|
| `Assets`|1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/assets)|session|Manage scripts and styles assets. Compres, minimize nad cache application resources|
| `Cron`|1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/cron)||Scheduling and automation of tasks|
| `Crypt` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/crypt)||Two-way data encryption using various cipher method, key and initialization verctors|
| `CSV` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/csv)||Operations on csv files|
| `Datetime` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/datetime)||Time and date management|
| `Filelog` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/fileLOG)||Collecting logs in files on the server|
| `Filesys` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/filesys)||Basic file and folder operations |
| `Format` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/format)||Formatting texts and numbers to various formats|
| `Image` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/image)||Converting, compressing, editing graphic files |
| `Ip-allow` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/ip-allow)||Manage the IP list with access to the website. |
| `Lang` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/lang)|pages|Multilingual application and translation system |
| `Math` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/math)||Mathematical functions and operations such as percentages, comparisons and calculations|
| `Pages` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/pages)||Managing pages, structure and url addresses of the application|
| `PsyllAPI` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/psyll_api)||Simple Psyll API connection|
| `Redirect` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/redirect)||Address redirection|
| `Registry` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/registry)||A registry containing system settings|
| `Sections` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/sections)|pages|Create the appearance of the application with the help of ready-made sections|
| `Session` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/session)||User session management |
| `Spy` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/spy)||Spying on user data such as ip, browser, operating system. |
| `Str` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/str)||String manipulation |
| `Upload` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/upload)||Upload files to the server |
| `Users` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/users)|crypt, spy, session|A user and users group system that allows to log in and manage user accounts|
| `Valid` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/valid)||Cata and form validation |
