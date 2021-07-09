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


# Packages list

| Function | Version || Require| Description |
|-------------|-------------|-------------|-------------|-------------|
| `assets`|1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/assets)|session|Manage scripts and styles assets. Compres, minimize nad cache application resources|
| `cron`|1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/cron)||Scheduling and automation of tasks|
| `crypt` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/crypt)||Two-way data encryption using various cipher method, key and initialization verctors|
| `csv` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/csv)||Operations on csv files|
| `datetime` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/datetime)||Time and date management|
| `fileLOG` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/fileLOG)||Collecting logs in files on the server|
| `filesys` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/filesys)||Basic file and folder operations |
| `format` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/format)||Formatting texts and numbers to various formats|
| `image` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/image)||Converting, compressing, editing graphic files |
| `ip-allow` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/ip-allow)||Manage the IP list with access to the website. |
| `lang` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/lang)|pages|Multilingual application and translation system |
| `markdown` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/markdown)||Markdown parser|
| `math` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/math)||Mathematical functions and operations such as percentages, comparisons and calculations|
| `pages` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/pages)||Managing pages, structure and url addresses of the application|
| `psyll_api` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/psyll_api)||Simple Psyll API connection|
| `redirect` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/redirect)||Address redirection|
| `registry` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/registry)||A registry containing system settings|
| `sections` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/sections)|pages|Create the appearance of the application with the help of ready-made sections|
| `session` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/session)||User session management |
| `spy` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/spy)||Spying on user data such as ip, browser, operating system. |
| `str` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/str)||String manipulation |
| `upload` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/upload)||Upload files to the server |
| `users` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/users)|crypt, spy, session|A user and users group system that allows to log in and manage user accounts|
| `valid` |1.0|[view](https://github.com/psyll/Codelab/blob/main/codelab/packages/valid)||Cata and form validation |

# Main Codelab defines

- `clLoad_start` - Load start in microtime
- `clVersion` - Version number
- `clCodename` - Version codename
- `clPath` - Codelab main folder path
- `clDomain` - Domain name
- `clProtocol` - Protocol `http` or `https`
- `clConfig` - Codelab main config
- `clPackages` - Codelab packages list
- `clLoad_end` - Load end in microtime

# All classes and functions list

## `cl` class

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

## `clDB` class

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

# Packages

## cl\\`assets`

 - `cl\assets::add(array $resources, $priority = 1)`
 - `cl\assets::get($type = null)`

## cl\\`cron`

 - `cl\cron::log(string $message)`
 - `cl\assets::jobs(bool $doOnly = false)`
 - `cl\assets::work()`

## cl\\`crypt`

 - `cl\crypt::in(string $string, array $param = null)`
 - `cl\crypt::out(string $hash, array $param = null)`

## cl\\`csv`

 - `cl\csv::parse(string $csvFile,string $delimiter = ';',string $enclosure = '"',bool $hasHeader = true)`

## cl\\`datetime`

 - `cl\datetime::now()`
 - `cl\datetime::date()`
 - `cl\datetime::time()`

## cl\\`fileLOG`

 - `cl\fileLOG::create(string $source, string $message)`

## cl\\`filesys`

 - `cl\filesys\file::exists(string $path)`
 - `cl\filesys\file::size(string $path)`
 - `cl\filesys\file::delete(string $path)`
 - `cl\filesys\file::count(string $path, $type = null)`
 - `cl\filesys\dir::list(string $path, $type = null, $ordering = 0)`
 - `cl\filesys\dir::tree(string $path)`
 - `cl\filesys\dir::clear(string $path)`
 - `cl\filesys\dir::size(string $path)`
 - `cl\filesys\dir::delete(string $path)`
 - `cl\filesys\dir::delete(string $path)`
 - `cl\filesys\dir::create(string $path, int $mode = 0755)`

## cl\\`format`

 - `cl\format::money(int $number)`
 - `cl\format::path(string $path)`
 - `cl\format::url(string $path)`

## cl\\`image`

 - `cl\image::checkGD(bool $throwException = true)`

## cl\\`lang`

 - `cl\lang::pageURL($id_or_alias)`
 - `cl\lang::display(array $translations)`
 - `cl\lang::pageURL($id_or_alias)`

## cl\\`markdown`

 - `cl\markdown::parse(string $content)`

## cl\\`math`

 - `cl\math::relativePercent(float $normal, float $current)`

## cl\\`pages`

 - `cl\pages::themeView()`
 - `cl\pages::list()`

## cl\\`psyll_api`

 - `cl\pages::status()`
 - `cl\pages::query($module = null, $parameters = null)`

## cl\\`redirect`

 - `cl\redirect::url(string $url)`
 - `cl\redirect::self()`
 - `cl\redirect::domain()`

## cl\\`registry`

 - `cl\registry::read(string $name, string $default = null)`

## cl\\`sections`

 - `cl\sections::control()`
 - `cl\sections::view($data)`

## cl\\`session`

 - `cl\session::set(string $name, $value = null)`
 - `cl\session::add(string $name, $value = null)`
 - `cl\session::get(string $name = null)`
 - `cl\session::delete(string $name = null)`

## cl\\`spy`

 - `cl\spy::ip()`
 - `cl\spy::netMask(string $ipAddress = null)`
 - `cl\spy::browser()`
 - `cl\spy::os()`

## cl\\`str`

 - `cl\str::pluralDisplay($number, $plural = 's', $singular = '')`
 - `cl\str::countWords(string $string)`
 - `cl\str::compare($string, $words)`
 - `cl\str::cleanForeign(string $string)`
 - `cl\str::cleanSpecial(string $string)`
 - `cl\str::alias(string $string)`

## cl\\`upload`

 - `cl\upload::file(string $source, string $destination, array $options)`


## cl\\`users`

 - `cl\users::passwordHash($password)`
 - `cl\users::login(string $email, string $password)`
 - `cl\users::logout()`
 - `cl\users::logged()`
 - `cl\users::data($userID = null)`
 - `cl\users::id()`
 - `cl\users::preference(string $name, string $value, $userID = null)`
 - `cl\users::preferenceSet(string $name, string $value, $userID = null)`
 - `cl\usersGroups::list()`
 - `cl\usersGroups::ids()`

## cl\\`valid`

 - `cl\valid::email(string $string)`
 - `cl\valid::md5hash(string $md5)`
 - `cl\valid::ip(string $ip)`
 - `cl\valid::url(string $url)`
 - `cl\valid::domain(string $url)`
 - `cl\valid::pesel(string $pesel)`
