# Database > Query (query)

## Function

`query(string $query, bool $fetch = false)`

## Parameters

 - `query` - mysqli result
 - `fetch` - *optional* - fetch automatically

## Examples

```php
$db->query(
    query: 'SELECT * FROM users'
    );
```

or using a simpler version

```php
$db->query('SELECT * FROM users');
```

Fetch results automaticly

```php
$db->query(
    query: 'SELECT * FROM users',
    fetch: true
);
```