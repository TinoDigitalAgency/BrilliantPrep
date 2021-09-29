<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Exceptions;

use GoDaddy\WordPress\MWC\Common\Exceptions\BaseException;

/**
 * An exception to be thrown when an email notification template isn't found.
 */
class EmailTemplateNotFoundException extends BaseException
{
    /** @var int HTTP status code */
    protected $code = 404;
}
