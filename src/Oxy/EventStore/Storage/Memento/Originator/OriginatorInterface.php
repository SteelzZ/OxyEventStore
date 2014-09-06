<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Storage\Memento\Originator;

use Oxy\EventStore\Storage\Memento\MementoInterface;

/**
 * Originator interface
 *
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */
interface OriginatorInterface
{
    /**
     * Create snapshot
     *
     * @return MementoInterface
     */
    public function createMemento();

    /**
     * Load snapshot
     *
     * @param MementoInterface $memento
     *
     * @return void
     */
    public function setMemento(MementoInterface $memento);
}