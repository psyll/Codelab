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
| **cron** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/cron)||scheduling and automation of tasks|
| **crypt** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/crypt)||string encryption using various cipher method, key and initialization verctor|
| **csv** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/csv)||operations on csv files |
| **datetime** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/datetime)||time and date management |
| **fileLOG** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/fileLOG)||collecting various logs in files on the server |
| **filesys** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/filesys)||file and folder operations |
| **format** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/format)||formatting texts and numbers |
| **image** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/image)||description|
| **ip-allow** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/ip-allow)||description|
| **lang** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/lang)|pages|description|
| **markdown** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/markdown)||description|
| **math** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/math)||description|
| **pages** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/pages)||description|
| **psyll_api** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/psyll_api)||description|
| **redirect** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/redirect)||description|
| **registry** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/registry)||description|
| **sections** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/sections)|pages|description|
| **session** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/session)||description|
| **spy** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/spy)||description|
| **str** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/str)||description|
| **upload** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/upload)||description|
| **users** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/users)|crypt,spy,session|description|
| **valid** |[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/valid)||description|


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