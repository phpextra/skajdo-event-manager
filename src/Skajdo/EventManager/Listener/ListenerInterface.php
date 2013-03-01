<?php

namespace Skajdo\EventManager\Listener;

use Skajdo\EventManager\Event\EventInterface;

/**
 * Abstract listener class
 *
 * @author      Jacek Kobus
 */
interface ListenerInterface
{
    /**
     * Run listener
     *
     * @param \Skajdo\EventManager\Event\EventInterface $event
     * @return void
     */
    public function run(EventInterface $event);
}