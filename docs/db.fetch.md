# Database > Fetch (fetch)

## Function

`fetch($result)`

## Parameters

 - `result` - mysqli result

## Return

Fetched mysql result

## Examples:

```php
$data = $db->query(
    query: 'SELECT * FROM users'
);
$dataFetch = $db->fetch($data);
```

or using a simpler version

```php
$data = $db->query('SELECT * FROM users');
$dataFetch = $db->fetch($data);
```

> NOTE! You can also fetch results automatically when calling query by setting the second parameter to `true`

```php
$data = $db->query(
    query: 'SELECT * FROM users',
    fetch: true // auto fetch
);
```