# Database > Fetch (fetch)

```php
$db->fetch($data);
```
Example:

```php
$data = $db->query('SELECT * FROM users');
$dataFetch = $db->fetch($data);
```

> NOTE! You can also use fetch results automatically when calling query by setting the second parameter to `true`
>
> ```php
> $data = $db->query('SELECT * FROM users', true); // auto fetch
> ```
>