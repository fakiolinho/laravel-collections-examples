# laravel-collections-examples
Laravel Collections Examples to help you grasp at once Laravel collections goodies

## Create a collection
	$man = ['id' => 1, 'name' => 'John Doe'];
	$woman = ['id' => 2, 'name' => 'Jane Doe'];

With method `make`:
  
	$collection = collect([$man, $woman]);

With helper function `collect`:

	$collection = Collection::make([$man, $woman]);
	
Result:
	
	$collection = [
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	];
	
## Collapse a collection

	$collection = [
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	];

Execute:
	
	$collection->collapse();
	
Result:

	['id' => 2, 'name' => 'Jane Doe']
	
## Check if collections contains an item

	$collection = [
		['id' => 1, 'name' => 'John Doe'],
		['id' => 2, 'name' => 'Jane Doe']
	];

Execute:
	
	$collections->contains(['id' => 1, 'name' => 'John Doe']);
	
Result:

	true

Execute:

	$collections->contains(['id' => 111111, 'name' => 'John Doe']);
	
Result:

	false
