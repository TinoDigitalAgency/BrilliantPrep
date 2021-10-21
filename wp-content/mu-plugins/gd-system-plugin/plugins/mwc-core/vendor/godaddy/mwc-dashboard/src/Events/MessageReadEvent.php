<?php

namespace GoDaddy\WordPress\MWC\Dashboard\Events;

/**
 * Message read event class.
 *
 * @since x.y.z
 */
class MessageReadEvent extends AbstractMessageEvent
{
    /** @var string the name of the event action */
    protected $action = 'read';
}
