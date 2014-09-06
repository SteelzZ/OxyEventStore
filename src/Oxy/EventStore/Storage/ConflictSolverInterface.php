<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Storage;

use Oxy\EventStore\EventProvider\EventProviderInterface;

/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author Tomas Bartkus <to.bartkus@gmail.com>
 */
interface ConflictSolverInterface
{
    /**
     * Implementation provides logic how to solve conflicts
     *
     * @param EventProviderInterface $currentEventProvider
     * @param EventProviderInterface $oldEventProvider
     * 
     * @return EventProviderInterface
     */
    public function solve(EventProviderInterface $currentEventProvider, EventProviderInterface $oldEventProvider);
}