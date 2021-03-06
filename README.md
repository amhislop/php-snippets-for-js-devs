# @amhislop/php-snippets-for-js-devs

# PHP Snippets for JavaScript Developers

![](https://img.shields.io/badge/version-1.0.0-blue?style=flat)
![](https://img.shields.io/badge/PHP-7.1+-blue?style=flat&logo=php)

## ![](/php-js-dummy-logo.svg)

A collection of immutable array functions for PHP that JS devs know and love.

## Functions

- [array_some](##array_some)
- [array_every](##array_every)
- [array_find](##array_find)
- [array_sort](##array_sort)
- [array_flat](##array_flat)
- [array_entries](##array_entries)
- [array_from_entries](##array_from_entries)

## Documentation

### array_some

---

#### Definition

```
array_some( callable $callback, array $array ) : bool
```

The array_some function checks if any elements in an array pass a conditional set by a callback function and returns a boolean based on whether the condition in callback is met for at least one array item.

**JS Equivilant**: _Array.some()_

#### Parameters

- **callback** - The function to execute per iteration

  ```
  callback( mixed $item [, int $index ] ) : bool
  ```

  - **item** - The current iteration
  - **index** - The current index

- **array** - The array to be iterated over

#### Return Values

Returns a boolean based on whether the condition in callback is met for at least one array item.

#### Usage

```php
$nums = [13, 85, 15, 23];

$result = array_some(function ($num) {
  return $num > 60;
}, $nums);

// $result: TRUE
```

### array_every

---

#### Definition

```
array_every( callable $callback, array $array ) : bool
```

The array_every function checks if all elements in an array pass a conditional set by a callback function and returns a boolean based on whether condition in callback is met for all array items.

**JS Equivilant**: _Array.every()_

#### Parameters

- **callback** - The function to execute per iteration

  ```
  callback( mixed $item [, int $index ] ) : bool
  ```

  - **item** - The current iteration
  - **index** - The current index

- **array** - The array to be iterated over

#### Return Values

Returns a boolean based on whether condition in callback is met for all array items.

#### Usage

```php
$nums = [13, 85, 15, 'John'];

$result = array_every(function ($num) {
  return is_numeric($num);
}, $nums);

// $result: FALSE
```

### array_find

---

#### Definition

```
array_find( callable $callback, array $array ) : mixed
```

The array_find function iterates through an array and returns the first item which meets the condition returned from the callback function.

**JS Equivilant**: _Array.find()_

#### Parameters

- **callback** - The function to execute per iteration

  ```
  callback( mixed $item [, int $index ] ) : bool
  ```

  - **item** - The current iteration
  - **index** - The current index

- **array** - The array to be iterated over

#### Return Values

Returns the first item which meets the condition returned from the callback function. If none of the items in the array meed the condtion the function NULL is returned

#### Usage

```php
$names = ['Sam', 'Damo', 'Kate', 'Lucy'];

$result = array_find(function ($name) {
  return $name === 'Lucy';
}, $names);

// $result: 'Lucy'
```

### array_sort

---

#### Definition

```
array_sort( array $array [, callable $callback ] ) : array
```

The array_sort function sorts the items of a given array based on positive, neutral or negative values returned from the callback function or if a callback is not supplied the array will be sorted based on numerical or alphabetical values.

**JS Equivilant**: _Array.sort()_

#### Parameters

- **array** - The array to be sorted
- **callback** - A function that compares two consecutive values in the array
  ```
  callback( mixed $first, mixed $second ) : bool
  ```
  - **first** - The first item for comparison.
  - **second** - The second item for comparison.

#### Return Values

The sorted array

#### Usage

```php
$nums = [1, 7, 3, 2, 8];

// Sort in descending order
$desc_nums = array_sort($nums, function ($first, $second) {
  return $second - $first;
});
// $desc_nums: [ 8, 7, 3, 2, 1 ]

// Sort in ascending order
$asc_nums = array_sort($nums);
// $asc_nums: [ 1, 2, 3, 7, 8 ]
```

### array_flat

---

#### Definition

```
array_flat( array $array [, mixed $depth = 1 ] ): array
```

The array_flat function creates a new array with all sub-array elements added into it recursively up to the specified depth. The predifined INF constant can be passed in to indicate infinate depth.

**JS Equivilant** _Array.flat()_

#### Paramaters

- **array** - The nested array to be flattened
- **depth** - Specifies how deep a nested array structure should be flattened. Defaults to 1.

#### Return Values

The new array with the sub-array values concatenated into it.

#### Usage

```php
$data = [ 1, 2, [ 3, 4, [ 5, 6, [ 7, 8 ] ] ] ];

$flattened_array = array_flat( $data, 2 );

// $flattened_array = [ 1, 2, 3, 4, 5, 6, [ 7, 8 ] ];
```

### array_entries

---

#### Definition

```
array_entries( array $array ) : array
```

The array_entries function returns a new array containing arrays of the keys and values of the given array

**JS Equivilant**: _Object.entries()_

#### Parameters

- **array** - The array whos _[key => value]_ pairs are to be returned

#### Return Values

An array of arrays containing the given arays _[key => value]_ pairs

#### Usage

```php
$key_value_array = [
  'Maths' => 95,
  'Physics' => 90,
  'Chemistry' => 96,
  'English' => 93,
  'Computer' => 90
];

$entries = array_entries($key_value_array);
// $entries: [
//   [ 'Maths', 95 ],
//   [ 'Physics', 90 ],
//   [ 'Chemistry', 96 ],
//   [ 'English', 93 ],
//   [ 'Computer', 90 ]
// ];
```

### array_from_entries

---

#### Definition

```
array_from_entries( array $array ) : array
```

The array_from_entries function restores a new _[key => value]_ array based on the arrays provided by the given array.

**JS Equivilant**: _Object.fromEntries()_

#### Parameters

- **array** - The array whos arrays are to be restored to a string-keyed _[key => value]_ format

#### Return Values

A new array of keyed properties matching the given arrays items

#### Usage

```php
$entries = [
  ['Maths', 95],
  ['Physics', 90],
  ['Chemistry', 96],
  ['English', 93],
  ['Computer', 90]
];

$key_value_array = array_from_entries($entries);

// $key_value_array: [
//   "Maths"  =>	95,
//   "Physics"  =>	90,
//   "Chemistry"  =>	96,
//   "English"  =>	93,
//   "Computer" =>	90
// ];
```

## License

MIT © [amhislop](https://github.com/amhislop)
