# laravel-collections-examples
Laravel Collections Examples to help you grasp at once Laravel collections goodies

## Create a collection
	$man = ['id' => 1, 'name' => 'John Doe'];
	$woman = ['id' => 2, 'name' => 'Jane Doe'];

With method `make`:
  
	$collection = collect([$man, $woman]);

With helper function `collect`:

	$collection = Collection::make([$man, $woman]);

