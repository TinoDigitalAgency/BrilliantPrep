<?php

namespace GoDaddy\WordPress\MWC\Dashboard\Events;

/**
 * Message unread event class.
 *
 * @since x.y.z
 */
class MessageUnreadEvent extends AbstractMessageEvent
{
    /** @var string the name of the event action */
    protected $action = 'unread';
}
