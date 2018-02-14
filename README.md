# query-builder
A query builder heavily inspired by Laravel's query builder. Supports PHP 5.3

I've taken a lot of time to make sure I didn't simply copy the code and release it in a different license. But they are so many ways to write the same code. 

There are some design patterns I love about Laravel's query builder. And there are some design patterns that I believe could have been done better. I've tried to push for a completely new implementations of the basic premise, but still using the same interface we all know and love from Laravel

## Usage
So far there's not much that can be done yet. But future goals including supporting most of the Laravel query building functions while providing an even more extensible and hackable interface

The only thing that's implemented yet is `where`

```php
<?php

use QueryBuilder\Model;

class User extends Model
{
    protected $primaryKey = 'id';
    
    protected $table      = 'table';
}
```


```php
<?php

// Short hand '=' supported
$model = User::where('column', $value); 
// Specify the operator
$model = User::where('column', '!=', $value);
// Specify the and/or value
$model = User::where('column', '!=', $value, 'or');

// Have the first argument be a callable, to specify parentheses around the query
$model = User::where('column', '=', 'foo');
$model = $model->where(function ($query) {
    $query->where('column2', 'bar');
    $query->where('column3', '>', 'baz');
    
}, 'or');


//compiled
var_dump([
    'sql' => $model->compile(),
    'bindings' => $model->getBindings()
]);
```
#### Output
```
array(2) {
  ["sql"]=>
  string(51) "`column` = ? or ( `column2` = ? and `column3` > ? )"
  ["bindings"]=>
  array(3) {
    [0]=>
    string(3) "foo"
    [1]=>
    string(3) "bar"
    [2]=>
    string(3) "baz"
  }
}
```
