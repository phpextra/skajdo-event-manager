<?php

/**
 * Copyright (c) 2013 Jacek Kobus <kobus.jacek@gmail.com>
 * See the file LICENSE.txt for copying permission.
 */

namespace PHPExtra\EventManager\Worker;

/**
 * The SortableWorkerQueueTest class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class SortableWorkerQueueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return WorkerQueueInterface
     */
    protected function createWorkerQueue()
    {
        return new SortableWorkerQueue();
    }

    public function testCreateEmptyQueueCreatesEmptyQueue()
    {
        $queue = $this->createWorkerQueue();
        $this->assertTrue($queue->isEmpty());
        $this->assertEquals(0, $queue->count());
        $this->assertEquals(0, count($queue));
    }

    public function testAddWorkerAddsWorkerToTheQueue()
    {
        $queue = $this->createWorkerQueue();
        $listener = $this->getMock('PHPExtra\EventManager\Listener\ListenerInterface');
        $worker1 = new Worker($listener, 'dummy1', 'dummy');
        $worker2 = new Worker($listener, 'dummy2', 'dummy');
        $worker3 = new Worker($listener, 'dummy3', 'dummy');

        $queue->addWorker($worker1);

        $this->assertFalse($queue->isEmpty());
        $this->assertEquals(1, $queue->count());
        $this->assertEquals(1, count($queue));

        $queue->addWorker($worker2);

        $this->assertFalse($queue->isEmpty());
        $this->assertEquals(2, $queue->count());
        $this->assertEquals(2, count($queue));

        $queue->addWorker($worker3);

        $this->assertFalse($queue->isEmpty());
        $this->assertEquals(3, $queue->count());
        $this->assertEquals(3, count($queue));

    }

    public function testWorkerQueueReturnsWorkersInLifoOrder()
    {
        $queue = $this->createWorkerQueue();
        $listener = $this->getMock('PHPExtra\EventManager\Listener\ListenerInterface');
        $worker1 = new Worker($listener, 'dummy1', 'dummy');
        $worker2 = new Worker($listener, 'dummy2', 'dummy');
        $worker3 = new Worker($listener, 'dummy3', 'dummy');

        $queue->addWorker($worker1);
        $queue->addWorker($worker2);
        $queue->addWorker($worker3);

        $output = array();

        foreach($queue as $worker){
            /** @var WorkerInterface $worker */
            $output[] = $worker->getMethod();
        }

        $this->assertEquals(array(
            'dummy3',
            'dummy2',
            'dummy1'
        ), $output);
    }
}