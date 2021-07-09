# Codelab


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


## Packages

| Function | | Require| Description |
|-------------|-------------|-------------|-------------|
| **assets** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/assets)|session|Manage scripts and styles assets. Compres, minimize nad cache application resources|
| **cron** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/cron)||Scheduling and automation of tasks|
| **crypt** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/crypt)||Two-way data encryption using various cipher method, key and initialization verctors|
| **csv** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/csv)||operations on csv files|
| **datetime** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/datetime)||time and date management|
| **fileLOG** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/fileLOG)||Collecting logs in files on the server|
| **filesys** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/filesys)||Basic file and folder operations |
| **format** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/format)||Formatting texts and numbers to various formats|
| **image** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/image)||Converting, compressing, editing graphic files |
| **ip-allow** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/ip-allow)||Manage the IP list with access to the website. |
| **lang** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/lang)|pages|Multilingual application and translation system |
| **markdown** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/markdown)||Markdown parser|
| **math** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/math)||Mathematical functions and operations such as percentages, comparisons and calculations|
| **pages** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/pages)||Managing pages, structure and url addresses of the application|
| **psyll_api** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/psyll_api)||Simple Psyll API connection|
| **redirect** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/redirect)||Address redirection|
| **registry** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/registry)||A registry containing system settings|
| **sections** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/sections)|pages|Create the appearance of the application with the help of ready-made sections|
| **session** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/session)||User session management |
| **spy** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/spy)||Spying on user data such as ip, browser, operating system. |
| **str** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/str)||String manipulation |
| **upload** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/upload)||Upload files to the server |
| **users** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/users)|crypt, spy, session|A user and users group system that allows to log in and manage user accounts|
| **valid** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/valid)||Cata and form validation |


## Main Codelab defines

- `clLoad_start` - Load start in microtime
- `clVersion` - Version number
- `clCodename` - Version codename
- `clPath` - Codelab main folder path
- `clDomain` - Domain name
- `clProtocol` - Protocol `http` or `https`
- `clConfig` - Codelab main config
- `clPackages` - Codelab packages list
- `clLoad_end` - Load end in microtime

## Main Codelab functions

### `cl` class

 - `cl::packageConfigRead(string $packageDir)`
 - `cl::requireAjax()`
 - `cl::isAjax()`
 - `cl::requirePost()`
 - `cl::isPost()`
 - `cl::headerStatus(int $statusCode)`;
 - `cl::headers(string $headerName = null)`
 - `cl::log(string $source, string $type, string $message)`
 - `cl::logs()`
 - `cl::output()`

### `clDB` class

 - `clDB::connected()`
 - `clDB::disconnect()`
 - `clDB::escape(string $string)`
 - `clDB::query(string $query)`
 - `clDB::fetch($results)`
 - `clDB::columns($table)`
 - `clDB::get(array $param, $single = false)`
 - `clDB::insert(string $table, array $columns)`
 - `clDB::delete(string $table, $id)`
 - `clDB::insertID()`
 - `clDB::update(string $table, string $where, array $fields)`