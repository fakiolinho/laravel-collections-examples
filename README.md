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
	
# Run a filter over each of the items

	$collection1 = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);
	
Execute:

	$collection2 = $collection1->filter(function($item){
		return $item['id'] < 2;
	});
	
Result:

	$collection2 = [
		['id' => 1, 'name' => 'John Doe']
	]);
	
Note:

This is the big difference with `each`. Here we can assign the result to a new collection since the filtered results are returned.

# Filter items by the given key value pair

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

# Filter items by the given key value pair using loose comparison


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
