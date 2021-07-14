# Database > Query (query)

```php
$db->query('SELECT * FROM users');
```
Fetch results automaticly

```php
$db->query('SELECT * FROM users', true);
```

Fetch results by `fetch` function

```php
$data = $db->query('SELECT * FROM users');
$dataFetch = $db->fetch($data);
```