# laravel-collections-examples
Laravel Collections Examples to help you grasp at once Laravel collections goodies

## Create a collection
	$man = ['id' => 1, 'name' => 'John Doe'];
	$woman = ['id' => 2, 'name' => 'Jane Doe'];

With method `make`:
  
	$collection = Collection::make([$man, $woman]);

With helper function `collect`:

	$collection = collect([$man, $woman]);
	
Result:
	
	$collection = [
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	];
	
## Collapse a collection

	$collection = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);

Execute:
	
	$collection->collapse();
	
Result:

	['id' => 2, 'name' => 'Jane Doe']
	
## Check if a collection contains an item

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
	
## Execute a callback over each collection's item	
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

Be careful it is just an iterator and it does return the collection itself without applying any changes to its items.
	
# Fetch a nested element of the collection

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
