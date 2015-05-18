# laravel-collections-examples
Laravel5 Collections Examples to help you grasp at once Laravel collections goodies

## make()

Create a new collection instance if the value isn't one already.

Method:

	public static function make($items = null);
	
Example:

	$man = ['id' => 1, 'name' => 'John Doe'];
	$woman = ['id' => 2, 'name' => 'Jane Doe'];

Execute with method `make()`:
  
	$collection = Collection::make([$man, $woman]);

Execute with helper function `collect()`:

	$collection = collect([$man, $woman]);
	
Result:
	
	$collection = [
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	];
	
## collapse()

Collapse a collection.

Method:

	public function collapse();
	
Example:

	$collection = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);

Execute:
	
	$collection->collapse();
	
Result:

	['id' => 2, 'name' => 'Jane Doe']
	
## contains()

Check if a collection contains an item.

Method:

	public function contains($key, $value = null);
	
Example:	

	$collection = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);

Execute:
	
	$collection->contains(['id' => 1, 'name' => 'John Doe']);
	
Result:

	true

Execute:

	$collection->contains(['id' => 111111, 'name' => 'John Doe']);
	
Result:

	false
	
## each()

Execute a callback over each collection's item.

Method:

	public function each(callable $callback);
	
Example:	

	$collection1 = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);
	
	$collection2 = collect();
	
Execute:

	$collection1->each(function($item) use ($collection2) {
		if($item['id'] < 2) $collection2[] = $item;
	});
	
Result:

	$collection2 = [
		['id' => 1, 'name' => 'John Doe']
	]);
	
Note:

Be careful it is just an iterator and it does return the collection itself without applying any changes to its items. Also since it uses a callback remember to use `use()` to call any variable you like inside the iterator.
	
## fetch()

Fetch a nested element of the collection.

Method:

	public function fetch($key);
	
Example:

	$collection = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);
	
Execute:

	$collection->fetch('id');
	
Result:

	[1, 3]
	
Execute:

	$collection->fetch('name');
	
Result:

	['John Doe', 'Jane Doe']
	
## filter()

Run a filter over each of the items.

Method:

	public function filter(callable $callback);
	
Example:

	$collection1 = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);
	
Execute:

	$collection2 = $collection1->filter(function($item) {
		return $item['id'] < 2;
	});
	
Result:

	$collection2 = [
		['id' => 1, 'name' => 'John Doe']
	]);
	
Note:

This is the big difference with `each`. Here we can assign the result to a new collection since the filtered results are returned.

## where()

Filter items by the given key value pair.

Method:

	public function where($key, $value, $strict = true);
	
Example:

	$collection1 = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);
	
Execute:

	$collection2 = $collection->where('id', 1);
	
Result:
	
	$collection2 = [
		['id' => 1, 'name' => 'John Doe']
	];
	
Execute:

	$collection2 = $collection->where('id', '1', true);
	
Result:
	
	$collection2 = [];
	
Execute:

	$collection2 = $collection->where('id', '1', false);
	
Result:
	
	$collection2 = [
		['id' => 1, 'name' => 'John Doe']
	];
	
Note:

Be careful, there is a third parameter named `strict` which is equal to true so by default the method tries to find for identical values and not just equal. If this changes then the method tries to find equal values.

## whereLoose()

Filter items by the given key value pair using loose comparison.

Method:

	public function whereLoose($key, $value);
	
Example:

	$collection1 = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);
	
Execute:

	$collection2 = $collection->whereLoose('id', 1);
	
Result:
	
	$collection2 = [
		['id' => 1, 'name' => 'John Doe']
	];
	
Execute:

	$collection2 = $collection->whereLoose('id', '1');
	
Result:
	
	$collection2 = [
		['id' => 1, 'name' => 'John Doe']
	];
	
Note:

It is exactly the same method as before but in this case it doesn't accept a third parameter and returns results by searching only for equal values.

## flatten()

Get a flattened array of the items in the collection.

Method:

	public function flatten();
	
Example:

	$collection = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);
	
Execute:

	$collection1 = $collection->flatten();
	
Result:
	
	$collection1 = [1, 'John Doe', 2, 'Jane Doe'];
	
## flip()

Flip the items in the collection.

Method:

	public function flip();
	
Example:

	$collection = collect(['id' => 1, 'name' => 'John Doe']);
	
Execute:

	$collection1 = $collection->flip();
	
Result:
	
	$collection1 = ['1' => 'id', 'John Doe' => 'name'];
	
## forget()

Remove an item from the collection by key.

Method:

	public function forget($key);
	
Example:

	$collection = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);
	
Execute:

	$collection->forget(1);
	
Result:
	
	$collection = [
		['id' => 1, 'name' => 'John Doe']
	];
	
Note:

Method `forget($key)` affects the collection without returning anything. So after we apply it we simply use the affected collection.

## get()

Get an item from a collection by key.

Method:

	public function get($key, $default = null);
	
Example:

	$collection1 = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);
	
Execute:

	$collection2 = $collection1->get(0);
	
Result:
	
	$collection2 = [
		['id' => 1, 'name' => 'John Doe']
	];
	
Execute:

	$collection2 = $collection1->get(25);
	
Result:
	
	null
	
Execute:

	$collection2 = $collection1->get(25, 1);
	
Result:
	
	$collection2 = 1;
	
Note:

In case the key we want doesn't exist the `get()` method returns the value of the second parameter as a fallback.

## groupBy()

Group an associative array by a field or using a callback.

Method:

	public function groupBy($groupBy);
	
Example:

	$collection = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe'],
		['id' => 3, 'name' => 'John Doe']
	]);
	
Execute:

	$collection->groupBy('name');
	
Result:
	
	$collection = [
		'John Doe' => [
			['id' => 1, 'name' => 'John Doe'],
			['id' => 3, 'name' => 'John Doe']
		],
		'Jane Doe' => [
			['id' => 2, 'name' => 'Jane Doe']
		]
	];
	
Execute:

	$collection->groupBy(function($item){
		return $item['name'] == 'John Doe';
	});
	
Result:

	$collection = [
		[
			['id' => 2, 'name' => 'Jane Doe']
		],
		[
			['id' => 1, 'name' => 'John Doe'],
			['id' => 3, 'name' => 'John Doe']
		]
	];
	
Note:

The parameter can be either a string like our first example either a callback function like our second example.

## keyBy()

Key an associative array by a field or using a callback.

Method:

	public function keyBy($keyBy);
	
Example:

	$collection = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe'],
		['id' => 3, 'name' => 'John Doe']
	]);
	
Execute:

	$collection->keyBy('name');
	
Result:
	
	$collection = [
		'John Doe' => [
			['id' => 3, 'name' => 'John Doe']
		],
		'Jane Doe' => [
			['id' => 2, 'name' => 'Jane Doe']
		]
	];
	
Execute:

	$collection->keyBy(function($item){
		return $item['name'] == 'John Doe';
	});
	
Result:

	$collection = [
		[
			['id' => 2, 'name' => 'Jane Doe']
		],
		[
			['id' => 3, 'name' => 'John Doe']
		]
	];
	
Note:

The parameter can be either a string like our first example either a callback function like our second example. The difference with `groupBy()` method is that here new results override previous ones because they share the same key.

## has()

Determine if an item exists in the collection by key.

Method:

	public function has($key);
	
Example:

	$collection = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe'],
		['id' => 3, 'name' => 'John Doe']
	]);
	
Execute:

	$collection->has(0);
	
Result:
	
	true
	
Execute:

	$collection->has(10);
	
Result:

	false
	
## implode()

Concatenate values of a given key as a string.

Method:

	public function implode($value, $glue = null);
	
Example:

	$collection = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe'],
		['id' => 3, 'name' => 'John Doe']
	]);
	
Execute:

	$collection->implode('id');
	
Result:
	
	'123'
	
Execute:

	$collection->implode('id', ',');
	
Result:
	
	'1,2,3'
	
Execute:

	$collection->implode('name', ', ');
	
Result:
	
	'John Doe, Jane Doe, John Doe'
	
## isEmpty()

Determine if a collection is empty or not.

Method:

	public function isEmpty();
	
Example:

	$collection1 = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe'],
		['id' => 3, 'name' => 'John Doe']
	]);
	
Execute:

	$collection1->isEmpty();
	
Result:
	
	false
	
Example:

	$collection2 = collect();
	
Execute:

	$collection2->isEmpty();
	
Result:
	
	true
