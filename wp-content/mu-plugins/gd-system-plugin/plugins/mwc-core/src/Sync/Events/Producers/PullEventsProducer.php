<?php

namespace GoDaddy\WordPress\MWC\Core\Sync\Events\Producers;

use DateTime;
use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Events\Contracts\EventContract;
use GoDaddy\WordPress\MWC\Common\Events\Contracts\ProducerContract;
use GoDaddy\WordPress\MWC\Common\Events\Events;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Core\Sync\Events\AbstractPullEvent;
use GoDaddy\WordPress\MWC\Core\Sync\Jobs\SyncJob;

/**
 * The producer for pull sync events.
 *
 * @since 2.13.0
 */
class PullEventsProducer implements ProducerContract
{
    /** @var string the pull objects action hook */
    const ACTION_PULL_OBJECTS = 'mwc_pull_objects';

    /**
     * Sets up the producer.
     *
     * @since 2.13.0
     *
     * @throws Exception
     */
    public function setup()
    {
        // set up the recurring action schedules for pull events
        Register::action()
            ->setGroup('admin_init')
            ->setHandler([$this, 'setupSchedules'])
            ->execute();

        // broadcast an event when called by Action Scheduler
        Register::action()
            ->setGroup(self::ACTION_PULL_OBJECTS)
            ->setHandler([$this, 'broadcastEvent'])
            ->execute();
    }

    /**
     * Broadcasts an event when called by Action Scheduler.
     *
     * This is a callback function for {@see as_schedule_recurring_action()}.
     *
     * @internal
     *
     * @since 2.13.0
     *
     * @param string|mixed $eventClass
     * @throws Exception
     */
    public function broadcastEvent($eventClass)
    {
        /* class must exist and implement {@see EventContract} */
        if (! is_string($eventClass) || ! class_exists($eventClass) || ! in_array(EventContract::class, (array) class_implements($eventClass), true)) {
            return;
        }

        Events::broadcast(new $eventClass(SyncJob::create()));
    }

    /**
     * Sets up the recurring action schedules for pull events.
     *
     * @internal
     *
     * @since 2.13.0
     *
     * @throws Exception
     */
    public function setupSchedules()
    {
        foreach (Configuration::get('sync.pulls') as $pull) {
            $interval = ArrayHelper::get($pull, 'interval');
            $event = ArrayHelper::get($pull, 'eventClass');

            if (! is_int($interval) || ! is_string($event)) {
                continue;
            }

            /** @var string|AbstractPullEvent $event class name */
            if (! $event::shouldSchedule() || $this->hasScheduledPull($event)) {
                continue;
            }

            $this->schedulePull($interval, $event);
        }
    }

    /**
     * Determines if there is a scheduled action for a given event.
     *
     * @since 2.14.0
     *
     * @param string $event class name
     * @return bool
     */
    private function hasScheduledPull(string $event) : bool
    {
        return (bool) as_next_scheduled_action(self::ACTION_PULL_OBJECTS, [$event]);
    }

    /**
     * Schedules a pull action.
     *
     * @since 2.14.0
     *
     * @param int $interval schedule interval
     * @param string $event class name
     */
    private function schedulePull(int $interval, string $event)
    {
        as_schedule_recurring_action(
            (new DateTime('now'))->getTimestamp(),
            $interval,
            self::ACTION_PULL_OBJECTS,
            [$event]
        );
    }
}
