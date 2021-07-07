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

## Defines

- `clLoad_start` - Load start in microtime
- `clVersion` - Version number
- `clCodename` - Version codename
- `clPath` - Codelab main folder path
- `clDomain` - Domain name
- `clProtocol` - Protocol `http` or `https`
- `clConfig` - Codelab main config
- `clPackages` - Codelab packages list
- `clLoad_end` - Load end in microtime

## `cl` class

 -  `cl::packageConfigRead(string $packageDir)`
 -  `cl::requireAjax()`
 -  `cl::isAjax()`
 -  `cl::requirePost()`
 -  `cl::isPost()`
 -  `cl::headerStatus(int $statusCode)`;
 -  `cl::headers(string $headerName = null)`
 -  `cl::log(string $source, string $type, string $message)`
 -  `cl::logs()`
 -  `cl::output()`
 -
## `clDB` class

 -  `clDB::connected()`
 -  `clDB::disconnect()`
 -  `clDB::escape(string $string)`
 -  `clDB::query(string $query)`
 -  `clDB::fetch($results)`
 -  `clDB::columns($table)`
 -  `clDB::get(array $param, $single = false)`
 -  `clDB::insert(string $table, array $columns)`
 -  `clDB::delete(string $table, $id)`
 -  `clDB::insertID()`
 -  `clDB::update(string $table, string $where, array $fields)`


