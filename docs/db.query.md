# Database > Query (query)

Function structure:

`query(string $query, $fetch = false)`

```php
$db->query('SELECT * FROM users');
```
Fetch results automaticly

```php
$db->query('SELECT * FROM users', true);
```