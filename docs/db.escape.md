# Database > Escape (escape)

## Function

`escape(string $string)`

## Parameters

 - `string` - string to be esacaped

## Return

Return the escaped version of given string

## Examples

```php
$db->escape('This is my "string"');
// return: This is my \"string\"
```