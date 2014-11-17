<?php

namespace Bazo\Events\DI;


use Nette;

/**
 * @author Martin Bažík <martin@bazik.sk>
 */
class EventsExtension extends Nette\DI\CompilerExtension
{

	const TAG_SUBSCRIBER = 'subscriber';

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('dispatcher'))
				->setClass(\Bazo\Events\EventDispatcher::class)
				->setInject(FALSE);
	}


	public function beforeCompile()
	{
		$builder	 = $this->getContainerBuilder();
		$map		 = $this->createSubscribersMap($builder);
		$dispatcher	 = $builder->getDefinition($this->prefix('dispatcher'));
		$dispatcher->setArguments([$map]);
	}


	private function createSubscribersMap(\Nette\DI\ContainerBuilder $builder)
	{
		$map = [];
		foreach ($builder->findByTag(self::TAG_SUBSCRIBER) as $serviceName => $tagProperties) {
			$def = $builder->getDefinition($serviceName);

			$class	 = $def->getClass();
			$events	 = $class::getSubscribedEvents();

			foreach ($events as $eventName => $callbacks) {
				foreach ($callbacks as $function) {
					$map[$eventName][] = [$serviceName, $function];
				}
			}
		}

		return $map;
	}


}
