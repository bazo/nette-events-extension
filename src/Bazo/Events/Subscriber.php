<?php

namespace Bazo\Events;


/**
 * @author Martin Bažík <martin@bazo.sk>
 */
interface Subscriber
{

	public static function getSubscribedEvents();
}
