<?php

use Illuminate\Support\Collection;

class HelpersCollectionsTest extends TestCase {

	public function testCollectionsAll()
	{
		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$this->assertEquals($collection->all(), [
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
	}

	public function testCollectionsChunk()
	{
		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->chunk(2);
		$this->assertEquals($collection2->all(), [collect([1,2]), collect([3,4]), collect([5])]);

		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->chunk(2, true);
		$this->assertEquals($collection2->all(), [collect([1,2]), collect([2 => 3, 3 => 4]), collect([4 => 5])]);
	}

	public function testCollectionsCollapse()
	{
		$collection1 = collect([
			[1,2,3,4,5],
			[6,7,8,9]
		]);
		$collection2 = $collection1->collapse();
		$this->assertEquals($collection2->all(), [1,2,3,4,5,6,7,8,9]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->collapse();
		$this->assertEquals($collection2->all(), ['id' => 2, 'name' => 'Jane Doe']);
	}

	public function testCollectionsCount()
	{
		$collection = collect([1,2,3,4,5]);
		$count = $collection->count();
		$this->assertEquals($count, 5);

		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$count = $collection->count();
		$this->assertEquals($count, 3);
	}

	public function testCollectionsDiff()
	{
		$collection1 = collect([1,2,3,4,5]);
		$collection2 = collect([1,4,5,6]);
		$collection3 = $collection1->diff($collection2);
		$this->assertEquals($collection3->all(), [1 => 2, 2 => 3]);

		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->diff([1]);
		$this->assertEquals($collection2->all(), [1 => 2, 2 => 3, 3 => 4, 4 => 5]);
	}

	public function testCollectionsEach()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = collect();
		$collection1->each(function($item) use ($collection2) {
			if($item['id'] > 1) $collection2[] = $item;
		});
		$this->assertEquals($collection2->all(), [
			['id' => 2, 'name' => 'Jane Doe']
		]);
	}

	public function testCollectionsFetch()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->fetch('id');
		$this->assertEquals($collection2->all(), [1, 2]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->fetch('name');
		$this->assertEquals($collection2->all(), ['John Doe', 'Jane Doe']);
	}

	public function testCollectionsFilter()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe', 'sex' => 1],
			['id' => 2, 'name' => 'Jane Doe', 'sex' => 2]
		]);
		$collection2 = $collection1->filter(function($item) {
			return $item['id'] > 1;
		});
		$this->assertEquals($collection2->all(), [
			1 => ['id' => 2, 'name' => 'Jane Doe', 'sex' => 2]
		]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe', 'sex' => 1],
			['id' => 2, 'name' => 'Jane Doe', 'sex' => 2],
			['id' => 3, 'name' => 'Jack Doe', 'sex' => 1],
		]);
		$men = $collection1->filter(function($item) {
			return $item['sex'] == 1;
		})->values();
		$women = $collection1->filter(function($item) {
			return $item['sex'] == 2;
		})->values();
		$this->assertEquals($men->all(), [
			['id' => 1, 'name' => 'John Doe', 'sex' => 1],
			['id' => 3, 'name' => 'Jack Doe', 'sex' => 1]
		]);
		$this->assertEquals($women->all(), [
			['id' => 2, 'name' => 'Jane Doe', 'sex' => 2]
		]);
	}

	public function testCollectionsFirst()
	{
		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$item = $collection->first();
		$this->assertEquals($item, ['id' => 1, 'name' => 'John Doe']);

		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$item = $collection->first(function($key, $value) {
			return $key > 0;
		});
		$this->assertEquals($item, ['id' => 2, 'name' => 'Jane Doe']);

		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$item = $collection->first(function($key, $value) {
			return $key > 10;
		}, [1,2,3]);
		$this->assertEquals($item, [1,2,3]);
	}

	public function testCollectionsFlatten()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->flatten();
		$this->assertEquals($collection2->all(), [1, 'John Doe', 2, 'Jane Doe']);
	}

	public function testCollectionsFlip()
	{
		$collection1 = collect(['id' => 1, 'name' => 'John Doe']);

		$collection2 = $collection1->flip();
		$this->assertEquals($collection2->all(), ['1' => 'id', 'John Doe' => 'name']);
	}

	public function testCollectionsForget()
	{
		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection->forget(0);
		$this->assertEquals($collection->all(), [
			1 => ['id' => 2, 'name' => 'Jane Doe']
		]);
		$this->assertEquals($collection->values()->all(), [
			['id' => 2, 'name' => 'Jane Doe']
		]);
	}

	public function testCollectionsForPage()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$collection2 = $collection1->forPage(2,2);
		$this->assertEquals($collection2->all(), [
			['id' => 3, 'name' => 'John Doe']
		]);
	}

	public function testCollectionsGet()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->get(0);
		$this->assertEquals($collection2, ['id' => 1, 'name' => 'John Doe']);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->get(25);
		$this->assertEquals($collection2, null);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->get(25, 1);
		$this->assertEquals($collection2, 1);
	}

	public function testCollectionsGroupBy()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$collection2 = $collection1->groupBy('name');
		$this->assertEquals($collection2->all(), [
			'John Doe' => [
				['id' => 1, 'name' => 'John Doe'],
				['id' => 3, 'name' => 'John Doe']
			],
			'Jane Doe' => [
				['id' => 2, 'name' => 'Jane Doe']
			]
		]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$collection2 = $collection1->groupBy(function($item) {
			return $item['name'] == 'John Doe';
		});
		$this->assertEquals($collection2->all(), [
			[
				['id' => 2, 'name' => 'Jane Doe']
			],
			[
				['id' => 1, 'name' => 'John Doe'],
				['id' => 3, 'name' => 'John Doe']
			]
		]);
	}

	public function testCollectionsKeyBy()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$collection2 = $collection1->keyBy('name');
		$this->assertEquals($collection2->all(), [
			'John Doe' => ['id' => 3, 'name' => 'John Doe'],
			'Jane Doe' => ['id' => 2, 'name' => 'Jane Doe']
		]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$collection2 = $collection1->keyBy(function($item) {
			return $item['name'] == 'John Doe';
		});
		$this->assertEquals($collection2->all(), [
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
	}

	public function testCollectionsHas()
	{
		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$result = $collection->has(0);
		$this->assertEquals($result, true);

		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$result = $collection->has(10);
		$this->assertEquals($result, false);
	}

	public function testCollectionsImplode()
	{
		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$result = $collection->implode('id');
		$this->assertEquals($result, '123');

		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$result = $collection->implode('id', ',');
		$this->assertEquals($result, '1,2,3');

		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$result = $collection->implode('name', ', ');
		$this->assertEquals($result, 'John Doe, Jane Doe, John Doe');
	}

	public function testCollectionsIntersect()
	{
		$collection1 = collect([1,2,3,4,5]);
		$collection2 = collect([1,4,5,6]);
		$collection3 = $collection1->intersect($collection2);
		$this->assertEquals($collection3->all(), [0 => 1, 3 => 4, 4 => 5]);

		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->intersect([1,4]);
		$this->assertEquals($collection2->all(), [0 => 1, 3 => 4]);

		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->intersect([1,4])->values();
		$this->assertEquals($collection2->all(), [0 => 1, 1 => 4]);
	}

	public function testCollectionsIsEmpty()
	{
		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$result = $collection->isEmpty();
		$this->assertFalse($result);

		$collection = collect();
		$result = $collection->isEmpty();
		$this->assertTrue($result);
	}

	public function testCollectionsKeys()
	{
		$collection1 = collect([1,2,3]);
		$collection2 = $collection1->keys();
		$this->assertEquals($collection2->all(), [0,1,2]);

		$collection1 = collect(['id' => 1, 'name' => 'John Doe']);
		$collection2 = $collection1->keys();
		$this->assertEquals($collection2->all(), ['id', 'name']);
	}

	public function testCollectionsLast()
	{
		$collection = collect([1,2,3]);
		$item = $collection->last();
		$this->assertEquals($item, 3);

		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$item = $collection->last();
		$this->assertEquals($item, ['id' => 3, 'name' => 'John Doe']);
	}

	public function testCollectionsLists()
	{
		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$list = $collection->lists('name');
		$this->assertEquals($list, ['John Doe', 'Jane Doe', 'John Doe']);

		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$list = $collection->lists('name', 'id');
		$this->assertEquals($list, [
			1 => 'John Doe',
			2 => 'Jane Doe',
			3 => 'John Doe'
		]);
	}

	public function testCollectionsMake()
	{
		$man = ['id' => 1, 'name' => 'John Doe'];
		$woman = ['id' => 2, 'name' => 'Jane Doe'];
		$collection = Collection::make([$man, $woman]);
		$this->assertEquals($collection->all(), [
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);

		$collection = collect();
		$this->assertEquals($collection->all(), []);
	}

	public function testCollectionsMap()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'John Doe']
		]);
		$collection2 = $collection1->map(function($item) {
			return ['id' => $item['id'] * 10, 'name' => $item['name'], 'age' => 30];
		});
		$this->assertEquals($collection2->all(), [
			['id' => 10, 'name' => 'John Doe', 'age' => 30],
			['id' => 20, 'name' => 'Jane Doe', 'age' => 30],
			['id' => 30, 'name' => 'John Doe', 'age' => 30]
		]);

		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->map(function($item) {
			return $item + 15;
		});
		$this->assertEquals($collection2->all(), [16,17,18,19,20]);
	}

	public function testCollectionsMerge()
	{
		$collection1 = collect([1,2,3]);
		$collection2 = collect([11,22,33]);
		$collection3 = $collection1->merge($collection2);
		$this->assertEquals($collection3->all(), [1,2,3,11,22,33]);

		$collection1 = collect([1,2,3]);
		$collection2 = $collection1->merge([111,222]);
		$this->assertEquals($collection2->all(), [1,2,3,111,222]);

		$collection1 = collect(['id' => 1, 'name' => 'John Doe']);
		$collection2 = $collection1->merge(['id' => 111]);
		$this->assertEquals($collection2->all(), ['id' => 111, 'name' => 'John Doe']);
	}

	public function testCollectionsOffsetExists()
	{
		$collection = collect([1,2,3,4,5]);
		$result = $collection->offsetExists(1);
		$this->assertTrue($result);

		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$result = $collection->offsetExists(5);
		$this->assertFalse($result);
	}

	public function testCollectionsOffsetGet()
	{
		$collection = collect([1,2,3,4,5]);
		$item = $collection->offsetGet(0);
		$this->assertEquals($item, 1);

		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$item = $collection->offsetGet(2);
		$this->assertEquals($item, ['id' => 3, 'name' => 'Jack Doe']);
	}

	public function testCollectionsOffsetSet()
	{
		$collection = collect([1,2,3,4,5]);
		$collection->offsetSet(2, 123);
		$this->assertEquals($collection->all(), [1,2,123,4,5]);

		$collection = collect([1,2,3,4,5]);
		$collection->offsetSet(5, 123);
		$this->assertEquals($collection->all(), [1,2,3,4,5,123]);
	}

	public function testCollectionsOffsetUnSet()
	{
		$collection = collect([1,2,3,4,5]);
		$collection->offsetUnset(2);
		$this->assertEquals($collection->all(), [0 => 1, 1 => 2, 3 => 4, 4 => 5]);

		$collection = collect([1,2,3,4,5]);
		$collection->offsetUnset(22);
		$this->assertEquals($collection->all(), [1,2,3,4,5]);
	}

	public function testCollectionsWhere()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->where('id', 1);
		$this->assertEquals($collection2->all(), [
			['id' => 1, 'name' => 'John Doe']
		]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->where('id', '1', true);
		$this->assertEquals($collection2->all(), []);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->where('id', '2', false);
		$this->assertEquals($collection2->all(), [
			1 => ['id' => 2, 'name' => 'Jane Doe']
		]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->where('id', '2', false)->values();
		$this->assertEquals($collection2->all(), [
			['id' => 2, 'name' => 'Jane Doe']
		]);
	}

	public function testCollectionsPop()
	{
		$collection = collect([1,2,3,4,5]);
		$item = $collection->pop();
		$this->assertEquals($item, 5);
		$this->assertEquals($collection->all(), [1,2,3,4]);
	}

	public function testCollectionsPrepend()
	{
		$collection = collect([1,2,3,4,5]);
		$collection->prepend(111);
		$this->assertEquals($collection->all(), [111,1,2,3,4,5]);
	}

	public function testCollectionsPush()
	{
		$collection = collect([1,2,3,4,5]);
		$collection->push(111);
		$this->assertEquals($collection->all(), [1,2,3,4,5,111]);
	}

	public function testCollectionsPull()
	{
		$collection = collect([1,2,3,4,5]);
		$item = $collection->pull(1);
		$this->assertEquals($item, 2);
		$this->assertEquals($collection->all(), [0 => 1, 2 => 3, 3 => 4, 4 => 5]);

		$collection = collect([1,2,3,4,5]);
		$item = $collection->pull(11, [1,2,3]);
		$this->assertEquals($item, [1,2,3]);
		$this->assertEquals($collection->all(), [1,2,3,4,5]);
	}

	public function testCollectionsPut()
	{
		$collection = collect([1,2,3,4,5]);
		$collection->put(1,11);
		$this->assertEquals($collection->all(), [1,11,3,4,5]);

		$collection = collect(['id' => 1, 'name' => 'John Doe']);
		$collection->put('id', 11);
		$this->assertEquals($collection->all(), ['id' => 11, 'name' => 'John Doe']);
	}

	public function testCollectionsRandom()
	{
		$collection = collect([1,2,3,4,5]);
		$item = $collection->random();
		$this->assertContains($item, $collection->all());

		$collection = collect(['id' => 1, 'name' => 'John Doe']);
		$items = $collection->random(2);
		$this->assertArraySubset($collection->all(), $items);
	}

	public function testCollectionsReduce()
	{
		$collection = collect([1,2,3,4,5]);
		$item = $collection->reduce(function($previous, $item) {
			return $previous.'/'.$item;
		});
		$this->assertEquals($item, "/1/2/3/4/5");

		$collection = collect([1,2,3,4,5]);
		$item = $collection->reduce(function($previous, $item) {
			return $previous.'/'.$item;
		}, 0);
		$this->assertEquals($item, "0/1/2/3/4/5");
	}

	public function testCollectionsReject()
	{
		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->reject(function($item) {
			return $item > 3;
		});
		$this->assertEquals($collection2->all(), [1,2,3]);

		$collection = collect([1,2,3,4,5]);
		$collection2 = $collection1->reject(function($item) {
			return $item < 4;
		});
		$this->assertEquals($collection2->all(), [3 => 4, 4 => 5]);

		$collection = collect([1,2,3,4,5]);
		$collection2 = $collection1->reject(function($item) {
			return $item < 4;
		})->values();
		$this->assertEquals($collection2->all(), [4,5]);
	}

	public function testCollectionsReverse()
	{
		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->reverse();
		$this->assertEquals($collection2->all(), [5,4,3,2,1]);

		$collection1 = collect(['id' => 1, 'name' => 'John Doe', 'sex' => 1]);
		$collection2 = $collection1->reverse();
		$this->assertEquals($collection2->all(), ['sex' => 1, 'name' => 'John Doe', 'id' => 1]);
	}

	public function testCollectionsSearch()
	{
		$collection = collect(['id' => 1, 'name' => 'John Doe', 'sex' => 1]);
		$result = $collection->search(1);
		$this->assertEquals($result, 'id');

		$collection = collect(['id' => 1, 'name' => 'John Doe', 'sex' => 1]);
		$collection->search('1', true);
		$this->assertEquals($result, 'id');

		$collection = collect(['id' => 1, 'name' => 'John Doe', 'sex' => 1]);
		$result = $collection->search('1');
		$this->assertEquals($result, 'id');
	}

	public function testCollectionsShift()
	{
		$collection = collect([1,2,3,4,5]);
		$item = $collection->shift();
		$this->assertEquals($item, 1);
		$this->assertEquals($collection->all(), [2,3,4,5]);

		$collection = collect([1]);
		$item = $collection->shift();
		$this->assertEquals($item, 1);
		$this->assertEquals($collection->all(), []);
	}

	public function testCollectionsSlice()
	{
		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->slice(2);
		$this->assertEquals($collection2->all(), [3,4,5]);

		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->slice(2,2);
		$this->assertEquals($collection2->all(), [3,4]);

		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->slice(2,2,true);
		$this->assertEquals($collection2->all(), [2 => 3, 3 => 4]);
	}

	public function testCollectionsSort()
	{
		$collection1 = collect([9,12,125,19,123]);
		$collection2 = $collection1->sort(function($b, $a) {
			return $b > $a;
		});
		$this->assertEquals($collection2->all(), [0 => 9, 1 => 12, 3 => 19, 4 => 123, 2 => 125]);

		$collection1 = collect([9,12,125,19,123]);
		$collection2 = $collection1->sort(function($b, $a) {
			return $b > $a;
		})->values();
		$this->assertEquals($collection2->all(), [9,12,19,123,125]);

		$collection1 = collect([9,12,125,19,123]);
		$collection2 = $collection1->sort(function($b, $a) {
			return $b < $a;
		})->values();
		$this->assertEquals($collection2->all(), [125,123,19,12,9]);
	}

	public function testCollectionsSortBy()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$collection2 = $collection1->sortBy('name');
		$this->assertEquals($collection2->all(), [
			2 => ['id' => 3, 'name' => 'Jack Doe'],
			1 => ['id' => 2, 'name' => 'Jane Doe'],
			0 => ['id' => 1, 'name' => 'John Doe']
		]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$collection2 = $collection1->sortBy('name')->values();
		$this->assertEquals($collection2->all(), [
			['id' => 3, 'name' => 'Jack Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 1, 'name' => 'John Doe']
		]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$collection2 = $collection1->sortBy(function($item){
			return $item['name'];
		})->values();
		$this->assertEquals($collection2->all(), [
			['id' => 3, 'name' => 'Jack Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 1, 'name' => 'John Doe']
		]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$collection2 = $collection1->sortBy('name', SORT_REGULAR, true)->values();
		$this->assertEquals($collection2->all(), [
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$collection2 = $collection1->sortBy(function($item){
			return $item['name'];
		}, SORT_REGULAR, true)->values();
		$this->assertEquals($collection2->all(), [
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
	}

	public function testCollectionsSortByDesc()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$collection2 = $collection1->sortByDesc('name');
		$this->assertEquals($collection2->all(), [
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$collection2 = $collection1->sortByDesc(function($item) {
			return $item['name'];
		}, SORT_REGULAR)->values();
		$this->assertEquals($collection2->all(), [
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
	}

	public function testCollectionsSplice()
	{
		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->splice(1,2);
		$this->assertEquals($collection1->all(), [1,4,5]);
		$this->assertEquals($collection2->all(), [2,3]);

		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->splice(1,2,[11,22]);
		$this->assertEquals($collection1->all(), [1,11,22,4,5]);
		$this->assertEquals($collection2->all(), [2,3]);

		$collection1 = collect([1,2,3,4,5]);
		$collection2 = $collection1->splice(1,2,[11,22,33,44]);
		$this->assertEquals($collection1->all(), [1,11,22,33,44,4,5]);
		$this->assertEquals($collection2->all(), [2,3]);
	}

	public function testCollectionsSum()
	{
		$collection = collect([1,2,3,4,5]);
		$sum = $collection->sum();
		$this->assertEquals($sum, 15);

		$collection = collect([
			['id' => 1, 'name' => 'John Doe', 'kids' => 2],
			['id' => 2, 'name' => 'Jane Doe', 'kids' => 1],
			['id' => 3, 'name' => 'Jack Doe', 'kids' => 3]
		]);
		$kids = $collection->sum('kids');
		$this->assertEquals($kids, 6);

		$collection = collect([1,2,3,4,5]);
		$sum = $collection->sum(function($item) {
			return $item;
		});
		$this->assertEquals($sum, 15);

		$collection = collect([
			['id' => 1, 'name' => 'John Doe', 'kids' => 2],
			['id' => 2, 'name' => 'Jane Doe', 'kids' => 1],
			['id' => 3, 'name' => 'Jack Doe', 'kids' => 3]
		]);
		$kids = $collection->sum(function($item) {
			return $item['kids'];
		});
		$this->assertEquals($kids, 6);
	}

	public function testCollectionsTake()
	{
		$collection1 = collect([1, 2, 3, 4, 5]);
		$collection2 = $collection1->take(2);
		$this->assertEquals($collection2->all(), [1,2]);

		$collection1 = collect([1, 2, 3, 4, 5]);
		$collection2 = $collection1->take(-2);
		$this->assertEquals($collection2->all(), [4,5]);
	}

	public function testCollectionsTransform()
	{
		$collection = collect([1,2,3,4,5]);
		$collection->transform(function($item) {
			return $item * 2;
		});
		$this->assertEquals($collection->all(), [2,4,6,8,10]);

		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$collection->transform(function($item) {
			return ['id' => $item['id'], 'skill' => 'web developer'];
		});
		$this->assertEquals($collection->all(), [
			['id' => 1, 'skill' => 'web developer'],
			['id' => 2, 'skill' => 'web developer'],
			['id' => 3, 'skill' => 'web developer']
		]);
	}

	public function testCollectionsUnique()
	{
		$collection1 = collect([1,2,1,4,5]);
		$collection2 = $collection1->unique();
		$this->assertEquals($collection2->all(), [0 => 1, 1 => 2, 3 => 4, 4 => 5]);

		$collection1 = collect([1,2,1,4,5]);
		$collection2 = $collection1->unique()->values();
		$this->assertEquals($collection2->all(), [1,2,4,5]);
	}

	public function testCollectionsValues()
	{
		$collection1 = collect([2 => 10, 'a' => 3, 1265 => 12]);
		$collection2 = $collection1->values();
		$this->assertEquals($collection2->all(), [10,3,12]);
	}

	public function testCollectionsToArray()
	{
		$collection = collect([1,2,3,4,5]);
		$array = $collection->toArray();
		$this->assertEquals($array, [1,2,3,4,5]);
	}

	public function testCollectionsToJson()
	{
		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$json = $collection->toJson();
		$this->assertEquals($json, '[{"id":1,"name":"John Doe"},{"id":2,"name":"Jane Doe"},{"id":3,"name":"Jack Doe"}]');
	}

	public function testCollectionsWhereLoose()
	{
		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->whereLoose('id', 1);
		$this->assertEquals($collection2->all(), [
			['id' => 1, 'name' => 'John Doe']
		]);

		$collection1 = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe']
		]);
		$collection2 = $collection1->whereLoose('id', '1');
		$this->assertEquals($collection2->all(), [
			['id' => 1, 'name' => 'John Doe']
		]);
	}

	public function testCollectionsToString()
	{
		$collection = collect([1,2,3,4,5]);
		$string = $collection->__toString();
		$this->assertEquals($string, '[1,2,3,4,5]');

		$collection = collect([
			['id' => 1, 'name' => 'John Doe'],
			['id' => 2, 'name' => 'Jane Doe'],
			['id' => 3, 'name' => 'Jack Doe']
		]);
		$string = $collection->__toString();
		$this->assertEquals($string, '[{"id":1,"name":"John Doe"},{"id":2,"name":"Jane Doe"},{"id":3,"name":"Jack Doe"}]');
	}

}
