<?php

namespace GoDaddy\WordPress\MWC\Dashboard\Events;

/**
 * Message dismissed event class.
 *
 * @since x.y.z
 */
class MessageDismissedEvent extends AbstractMessageEvent
{
    /** @var string the name of the event action */
    protected $action = 'dismiss';
}
