<?php

/**
 * Copyright (c) 2013 Jacek Kobus <kobus.jacek@gmail.com>
 * See the file LICENSE.txt for copying permission.
 */

namespace Skajdo\EventManager;

/**
 * Class EventManagerAwareInterface
 * @package Skajdo\EventManager
 */
interface EventManagerAwareInterface
{
    /**
     * Set EventManager instance
     *
     * @param EventManager $manager
     * @return $this
     */
    public function setEventManager(EventManager $manager);
}