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

## Packages

 -  [assets](https://github.com/psyll/Codelab/blob/main/codelab/packages/assets)
 -  [cron](https://github.com/psyll/Codelab/blob/main/codelab/packages/cron)
 -  [crypt](https://github.com/psyll/Codelab/blob/main/codelab/packages/crypt)
 -  [csv](https://github.com/psyll/Codelab/blob/main/codelab/packages/csv)
 -  [datetime](https://github.com/psyll/Codelab/blob/main/codelab/packages/datetime)
 -  [fileLOG](https://github.com/psyll/Codelab/blob/main/codelab/packages/fileLOG)
 -  [filesys](https://github.com/psyll/Codelab/blob/main/codelab/packages/filesys)
 -  [format](https://github.com/psyll/Codelab/blob/main/codelab/packages/format)
 -  [image](https://github.com/psyll/Codelab/blob/main/codelab/packages/image)
 -  [ip-allow](https://github.com/psyll/Codelab/blob/main/codelab/packages/ip-allow)
 -  [lang](https://github.com/psyll/Codelab/blob/main/codelab/packages/lang)
 -  [markdown](https://github.com/psyll/Codelab/blob/main/codelab/packages/markdown)
 -  [math](https://github.com/psyll/Codelab/blob/main/codelab/packages/math)
 -  [pages](https://github.com/psyll/Codelab/blob/main/codelab/packages/pages)
 -  [psyll_api](https://github.com/psyll/Codelab/blob/main/codelab/packages/psyll_api)
 -  [redirect](https://github.com/psyll/Codelab/blob/main/codelab/packages/redirect)
 -  [registry](https://github.com/psyll/Codelab/blob/main/codelab/packages/registry)
 -  [sections](https://github.com/psyll/Codelab/blob/main/codelab/packages/sections)
 -  [session](https://github.com/psyll/Codelab/blob/main/codelab/packages/session)
 -  [spy](https://github.com/psyll/Codelab/blob/main/codelab/packages/spy)
 -  [str](https://github.com/psyll/Codelab/blob/main/codelab/packages/str)
 -  [upload](https://github.com/psyll/Codelab/blob/main/codelab/packages/upload)
 -  [users](https://github.com/psyll/Codelab/blob/main/codelab/packages/users)
 -  [valid](https://github.com/psyll/Codelab/blob/main/codelab/packages/valid)