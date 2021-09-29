<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\API;

use Exception;
use GoDaddy\WordPress\MWC\Common\Components\Contracts\ComponentContract;
use GoDaddy\WordPress\MWC\Common\Components\Exceptions\ComponentLoadFailedException;
use GoDaddy\WordPress\MWC\Common\Components\Traits\HasComponentsTrait;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\API\Controllers\EmailNotificationsController;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\API\Controllers\EmailTemplatesController;

/**
 * Email notifications API handler.
 *
 * @since x.y.z
 */
class API implements ComponentContract
{
    use HasComponentsTrait;

    /** @var array */
    protected $componentClasses = [
        EmailNotificationsController::class,
        EmailTemplatesController::class,
    ];

    /**
     * Loads the API component.
     *
     * @since x.y.z
     *
     * @throws Exception
     */
    public function load()
    {
        Register::action()
            ->setGroup('rest_api_init')
            ->setHandler([$this, 'registerRoutes'])
            ->execute();
    }

    /**
     * Registers the email notifications REST API routes.
     *
     * @see API::setup()
     *
     * @internal
     *
     * @since x.y.z
     *
     * @throws ComponentLoadFailedException
     */
    public function registerRoutes()
    {
        $this->loadComponents();
    }
}
