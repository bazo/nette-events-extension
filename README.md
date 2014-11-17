nette-events-extension
======================

Really simple events dispatcher for Nette Framework.

Usage:

add this to your config.neon

````
extensions:
	- Bazo\Events\DI\EventsExtension

services:
	- {class: Listener1, tags: [subscriber]}
	- {class: Listener2, tags: [subscriber]}
	...
````

A subscriber must implement getSubscribedEvents static function from Bazo\Events\Subscriber interface

```php
class Listener1 implements Bazo\Events\Subscriber
{
	public static function getSubscribedEvents()
	{
		return [
			'event1' => [
				'callback1',
				'callback2',
			],
			'event2' => [
				'callback3',
				'callback4',
			]
		];
	}

	public function callback1($arg1, $arg2, ...) {...}
}
```

Callbacks are function names.

Then you dispatch an event like this:
```php
$args = [
	$arg1,
	$arg2
];
$dispatcher->dispatchEvent('event1', $args);
```
