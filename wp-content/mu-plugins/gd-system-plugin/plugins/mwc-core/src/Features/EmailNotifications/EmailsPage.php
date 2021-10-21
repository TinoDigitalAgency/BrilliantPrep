<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications;

use Exception;
use GoDaddy\WordPress\MWC\Common\Components\Contracts\ComponentContract;
use GoDaddy\WordPress\MWC\Common\Content\AbstractAdminPage;
use GoDaddy\WordPress\MWC\Common\Register\Register;

/**
 * Email notifications page.
 */
class EmailsPage extends AbstractAdminPage implements ComponentContract
{
    /** @var string the page and menu item slug */
    const SLUG = 'godaddy-email-notifications';

    /** @var string parent menu item identifier */
    const PARENT_MENU_ITEM = 'woocommerce-marketing';

    /** @var string required capability to interact with page and related menu item */
    const CAPABILITY = 'manage_options';

    /**
     * Initializes the email notifications page.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->screenId = static::SLUG;
        $this->title = __('Email Notifications', 'mwc-core');
        $this->menuTitle = __('Emails', 'mwc-core');
        $this->parentMenuSlug = static::PARENT_MENU_ITEM;
        $this->capability = static::CAPABILITY;

        parent::__construct();
    }

    /**
     * Initializes the Emails admin page.
     *
     * @throws Exception
     */
    public function load()
    {
        $this->registerHooks();
    }

    /**
     * Registers filters.
     *
     * @throws Exception
     */
    protected function registerHooks()
    {
        Register::filter()
            ->setGroup('load-marketing_page_godaddy-email-notifications')
            ->setHandler([$this, 'registerAdminHooks'])
            ->setPriority(10)
            ->execute();
    }

    /**
     * Registers admin filters.
     *
     * @internal
     * @see EmailsPage::registerHooks()
     *
     * @throws Exception
     */
    public function registerAdminHooks()
    {
        Register::filter()
            ->setGroup('admin_footer_text')
            ->setHandler([$this, 'removeDefaultAdminFooter'])
            ->setPriority(10)
            ->execute();
    }

    /**
     * Removes the default footer from the admin page.
     *
     * @internal
     *
     * @since x.y.z
     *
     * @return string
     */
    public function removeDefaultAdminFooter() : string
    {
        return '';
    }

    /**
     * Determines whether the menu item for the page should be added.
     *
     * @internal
     * @see AbstractAdminPage::registerMenuItem()
     *
     * @return bool
     */
    public function shouldAddMenuItem() : bool
    {
        return (bool) current_user_can($this->getCapability() ?? static::CAPABILITY);
    }

    /**
     * Adds the menu item.
     *
     * Overrides the parent method.
     *
     * @internal
     * @see AbstractAdminPage::registerMenuItem()
     *
     * @return self
     */
    public function addMenuItem() : AbstractAdminPage
    {
        $menuTitle = $this->getMenuTitle() ?? $this->getTitle();

        add_submenu_page(
            $this->getParentMenuSlug(),
            $this->getTitle(),
            $menuTitle.'<span class="update-plugins"><span class="update-count">new</span></span>',
            $this->getCapability(),
            $this->getScreenId(),
            [$this, 'render']
        );

        return $this;
    }

    /**
     * Renders the Emails page HTML.
     *
     * @internal
     * @see EmailsPage::addMenuItem()
     */
    public function render()
    {
        ?>
        <div id="mwc-email-notifications"></div>
        <?php
    }
}
