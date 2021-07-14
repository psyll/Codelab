## Table of Contents

- [Installation](#installation)
  - [The Codelab Installer](#the-codelab-installer)
  - [Manual installation](#manual-installation)
- [Configuration file](#configuration-file)
- [Built-in classes](#built-in-classes)
  - [clApp](#clapp)
    - [clApp::create(array $configParm)](#clappcreatearray-configparm)
  - [clError](#clerror)
    - [clError::create(array $data)](#clerrorcreatearray-data)
  - [clLog](#cllog)
    - [clLog::file(string $source, string $message)](#cllogfilestring-source-string-message)
    - [clLog::create(string $source, string $type, string $message)](#cllogcreatestring-source-string-type-string-message)
    - [clLog::get()](#cllogget)
    - [clLog::sources()](#cllogsources)
    - [clLog::types()](#cllogtypes)
  - [clSession](#clsession)
    - [clSession::set(string $name, $value = null)](#clsessionsetstring-name-value--null)
    - [clSession::add(string $name, $value = null)](#clsessionaddstring-name-value--null)
    - [clSession::get(string $name = null)](#clsessiongetstring-name--null)
    - [clSession::delete(string $name = null)](#clsessiondeletestring-name--null)
  - [clUser](#cluser)
    - [clUser::list()](#cluserlist)
    - [clUser::set(string $username, string $settingName, $setingValue)](#clusersetstring-username-string-settingname-setingvalue)
    - [clUser::get(string $username, string $settingName)](#clusergetstring-username-string-settingname)
    - [clUser::passwordHash(string $password)](#cluserpasswordhashstring-password)
    - [clUser::login($username, $password, $custom_requirments = null)](#cluserloginusername-password-custom_requirments--null)
    - [clUser::logout()](#cluserlogout)
    - [clUser::logged()](#cluserlogged)

## Introduction

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

### Ease of use

The application is based on basic knowledge of PHP, CSS, HTML and JavaScript. Extensive documentation will guide you through each step of the application development.

### Size

We have made every effort to keep the system as small as possible. Each file has been optimized to reduce size and increase performance.

** Current size of this repository:**

![Size](https://img.shields.io/github/repo-size/psyll/Codelab)

# Installation

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

## The Codelab Installer

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

## Manual installation

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

# Configuration file

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

# Built-in classes

## clApp

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

### clApp::create(array $configParm)

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
clApp::create([
	"name" => "Kickstart",
	"version" => "1.0.1",
	"description" => "The Codelab Application Example",
	"url" => "http://localhost/Projects/Codelab/upload/",
	"dir" => __DIR__,
	"author"=> [
		"name" => "Jarek Szulc",
		"email" => "jarek@psyll.com",
		"url" => "https://psyll.com"
	]
]);
echo '<pre>';
print_r(clApp);
echo '</pre>';
/* return Array
 (
     [dir] => D:\Projects\Codelab\upload\app
     [source] => config/config.json
     [name] => Kickstart
     [version] => 1.0.1
     [description] => The Codelab Application Example
     [url] => http://localhost/Projects/Codelab/upload/
     [author] => Array
         (
             [name] => Jarek Szulc
             [email] => jarek@psyll.com
             [url] => https://psyll.com
         )
 )
 */
```

```php
// Automated "dir" define
clApp::create(["source" => "config/config.json", "dir" => __DIR__]);
```

```php
clApp::create(["source" => "config/config.json"]
]);
/*
Example of config.json file content
{
  "dir": "/Projects/Codelab/upload/app",
  "name": "Kickstart",
  "version": "1.0.1",
  "description": "The Codelab Application Example",
	"url": "http://localhost/Projects/Codelab/upload/",
	"author": {
		"name": "Jarek Szulc",
		"email": "jarek@psyll.com",
		"url": "https://psyll.com"
  }
}
*/
echo '<pre>';
print_r(clApp);
echo '</pre>';
/* return Array
(
	[dir] => D:\Projects\Codelab\upload\app
	[source] => config/config.json
	[name] => Kickstart
	[version] => 1.0.1
	[description] => The Codelab Application Example
	[url] => http://localhost/Projects/Codelab/upload/
	[author] => Array
		(
			[name] => Jarek Szulc
			[email] => jarek@psyll.com
			[url] => https://psyll.com
		)
)
*/
```

## clError

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

### clError::create(array $data)

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
$clError = [
    'alias' => 'YOUR_ERROR_ALIAS',
    'source' => __FILE__,
    'file' => clPath . DIRECTORY_SEPARATOR . 'myFile.php',
    'message' => "Custom error message",
    'tip' => "Tip how to fix current error",
];
clError::create($clError);
```

## clLog

### clLog::file(string $source, string $message)

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
clLog::file('SOURCE_NAME', 'custom field|false');
```

### clLog::create(string $source, string $type, string $message)

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Possible values for the `$type` variable

- info
- warning
- error

#### Examples

```php
$myMessage = 'This is new test log';
clLog::create('SOURCE_NAME', 'info', $myMessage);
```

### clLog::get()

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
echo '<pre>';
print_r(clLog::get());
echo '</pre>';
// return
// Array
// (
//     [0.56667900 1624383607] => Array
//         (
//             [source] => define
//             [type] => info
//             [message] => [clDomain] defined as [localhost]
//         )
//
//     [0.56668600 1624383607] => Array
//         (
//             [source] => define
//             [type] => info
//             [message] => [clProtocol] defined as [http]
//         )
//
//     [0.56669300 1624383607] => Array
//         (
//             [source] => define
//             [type] => info
//             [message] => [clUrlCurrent] defined as [http://localhost/Projects/Codelab/upload]
//         )
// )
```



### clLog::sources()

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
print_r(clLog::sources());
// return:
// Array ( [0] => define [1] => source1 [2] => source2 )
```
### clLog::types()

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
print_r(clLog::types()));
// return:
// Array ( [0] => info [1] => success [2] => error )
```

## clSession

### clSession::set(string $name, $value = null)

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
clSession::set('SESSION_NAME', 'SESSION_VALUE');
clSession::set('SESSION_NAME', $sessionSet);
```
```php
$sessionSet = ['name1'=>'value1', 'name2'=>'value2'];
clSession::set('SESSION_NAME', $sessionSet);
```

### clSession::add(string $name, $value = null)

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
clSession::add(string $name, $value = null){
```
```php
$sessionAdd = ['name1'=>'value1', 'name2'=>'value2'];
clSession::add('SESSION_NAME', $sessionAdd);
```

### clSession::get(string $name = null)

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
clSession::set('SomeName', 'This is value');
echo clSession::get('SomeName')
// return string "This is value"
```
```php
$sessionAdd = ['name1'=>'value1', 'name2'=>'value2'];
clSession::set('SomeName', $sessionAdd);
print_r(clSession::get('SomeName');
// return array ( [name1] => value1 [name2] => value2 )
```

### clSession::delete(string $name = null)

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
clSession::delete('SomeName');
```

## clUser

### clUser::list()

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
echo '<pre>';
print_r(clUser::list());
echo '</pre>';
// return
// Array
//(
//     [jarek] => Array
//        (
//             [terminal] => true
//             [firstname] => Jarek
//             [lastname] => Szulc
//             [email] => jarek@psyll.com
//             [password] => TFIrU3pTREl0T0VKKzRvczVzL3hOS2M5ZmNPbUN1bHkxNFJ2RUZDcTR2SStZWEFfdgeaTNReUxid1lDRUfesfewfLM2JQemNFZ1efwefwefwefBmZjN4TH==
//         )
//     [root] => Array
//         (
//             [terminal] => true
//             [email] => root@psyll.com
//             [password] => TFIrU3pTREl0T0VKKzRvczVzL3hOS2M5ZmNPbUN1bHkxNFJ2RUZDcTR2SStZaTNReUxid1lDRU1LM2JQemNFZ1BmZjN4THZ3VWQrNW9LeFg0ZnY5S0E9PQ==
//         )
//
// )
```

### clUser::set(string $username, string $settingName, $setingValue)

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
clUser::set('root', 'SettingName', 'SettingValue');
```

### clUser::get(string $username, string $settingName)

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
echo clUser::get('root', 'SettingName');
```

### clUser::passwordHash(string $password)

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
echo clUser::passwordHash('MyPasword');
return string "SStZSjdzblgwZTBVa1FXV3ZITWlSVEZ6SkIzVmNMK3FYbXd0L3Y2WFBEYmhSSThVMHlWRTU3WThYK3lTWTBTU2hpYWhmMlBwanpHZXlGdFI4Z2xMSHc9PQ=="
```

### clUser::login($username, $password, $custom_requirments = null)

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
cluser::login('MyUsername', 'MyPassword');
```
```php
$login = json_decode(cluser::login($username, $password), true);
if ($login['status'] == '1'):
    echo "Logged in (" . $login['message'] . ")";
else:
    echo "Not logged in (" . $login['message'] . ")";
endif;
```
```php
$login = cluser::login($username, $password, ['terminal' => "true"]));
if ($login['status'] == '1'):
    echo "Logged";
else:
    echo "Not logged";
endif;
```

### clUser::logout()

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
clUser::logout()
```

### clUser::logged()

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

#### Examples

```php
if (clUser::logged()):
    echo "Im logged";
else:
    echo "Im not logged";
endif;
```
```php
echo clUser::logged()['username'];
// return string "root"
```
```php
echo '<pre>';
print_r(clUser::logged());
echo '</pre>';
// return
// Array
// (
//     [username] => root
//     [data] => Array
//         (
//             [terminal] => true
//             [email] => root@psyll.com
//        )
//     [token] => S1ZIdVV6STJzZDF3cXVKY1V6WjI4bjlIZmdYTFNieVNTMjZyV0k5NHZWRlF3TWpqMFJaMGNpMTVaN042MTZHcDlTN1BWQXF5TWxTR2xqd2xveFpXRUFJeEloSm1yN0dWYkdQSkNVVENPcWdwTGNsYm1raUIxSzI2alVZYWJSTDQ1UHRtMXBRR1M4eXZWVDZXdUZncUJRPT0=
//     [update] => 2021-06-22 19:22:59
// )
```






