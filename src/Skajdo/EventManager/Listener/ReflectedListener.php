<?php

/**
 * Copyright (c) 2013 Jacek Kobus <kobus.jacek@gmail.com>
 * See the file LICENSE.md for copying permission.
 */

namespace Skajdo\EventManager\Listener;

/**
 * Uses reflection to obtain information about what event listener is listening to.
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class ReflectedListener extends AbstractReflectedListener implements NormalizedListenerInterface
{
    /**
     * @var ListenerInterface
     */
    protected $listener;

    /**
     * @var ListenerMethod[]
     */
    protected $methods;

    /**
     * Wrap listener into ReflectedListener to obtain information about events
     *
     * @param ListenerInterface $listener
     */
    function __construct(ListenerInterface $listener)
    {
        $this->listener = $listener;
    }

    /**
     * @return ListenerInterface
     */
    public function getListener()
    {
        return $this->listener;
    }

    /**
     * {@inheritdoc}
     */
    public function getListenerMethods()
    {
        $methods = array();

        if($this->methods === null){
            $reflectedListener = new \ReflectionClass($listenerClass = get_class($this->listener));
            foreach ($reflectedListener->getMethods() as $method) {

                if (($method->getNumberOfParameters() > 1) || !($param = current($method->getParameters()))) {
                    continue;
                }

                if (($eventClassName = $this->getEventClassNameFromParam($param)) === null) {
                    continue;
                }

                $priority = $this->getPriority($method);
                $methods[] = new ListenerMethod($this, $method->getName(), $eventClassName, $priority);
            }
        }else{
            $methods = $this->methods;
        }
        return $methods;
    }

    /**
     * Try to find a priority for given method
     *
     * @param \ReflectionMethod $method
     * @return int|null
     */
    protected function getPriority(\ReflectionMethod $method)
    {
        $priority = null;
        //@todo get priority
//        if($method->getDocBlock() !== false){
//            /** @var $tag \Zend\Code\Reflection\DocBlock\Tag\GenericTag */
//            $tag = $method->getDocBlock()->getTag('priority');
//
//            if($tag !== false){
//                if(is_numeric($tag->getContent())){
//                    $priority = (int)$tag->getContent();
//                }else{
//                    $priority = Priority::getPriorityByName($tag->getContent());
//                }
//            }
//        }
        return $priority;
    }
}