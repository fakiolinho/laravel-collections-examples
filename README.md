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
	
## Find the differences between collections
	
	$collection1 = collect([
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);
	
	$collection2 = collect([
		['id' => 3, 'name' => 'Jack Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	]);
	
Execute:

	$collection1->diff($collection2);
	
Result:

	
