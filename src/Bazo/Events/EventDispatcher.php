<?php

namespace Bazo\Events;


use Nette;

/**
 * @author Martin Bažík <martin@bazik.sk>
 */
class EventDispatcher
{

	/** @var array */
	private $subscribersMap = [];

	/** @var \Nette\DI\Container */
	private $container;

	/**
	 * @param array $subscribersMap
	 * @param Nette\DI\Container $container
	 */
	public function __construct(array $subscribersMap, Nette\DI\Container $container)
	{
		$this->subscribersMap	 = $subscribersMap;
		$this->container		 = $container;
	}


	public function dispatchEvent($eventName, $eventArgs = [])
	{
		if (isset($this->subscribersMap[$eventName])) {
			$subscribers = $this->subscribersMap[$eventName];
			foreach ($subscribers as list($serviceName, $function)) {
				$service = $this->container->getService($serviceName);
				call_user_func_array([$service, $function], $eventArgs);
			}
		}
	}


}
