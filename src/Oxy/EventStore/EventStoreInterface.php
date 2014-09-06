<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore;

use Oxy\Core\Guid;
use Oxy\EventStore\EventProvider\EventProviderInterface;

/**
 * Event store interface
 *
 * @category Oxy
 * @package  Oxy\EventStore
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */
interface EventStoreInterface
{
    /**
     * Return event provider
     *
     * @param Guid $eventProviderGuid
     * @param EventProviderInterface $eventProvider
     *
     * @return EventProviderInterface
     */
    public function getById(
        Guid $eventProviderGuid,
        EventProviderInterface $eventProvider
    );

    /**
     * Store event provider
     *
     * @param EventProviderInterface $eventProvider
     *
     * @return void
     */
    public function add(EventProviderInterface $eventProvider);

    /**
     * Commit all events
     *
     * @throws Storage\ConcurrencyException
     *
     * @return void
     */
    public function commit();

    /**
     * Rollback everything
     *
     * @return void
     */
    public function rollback();
}