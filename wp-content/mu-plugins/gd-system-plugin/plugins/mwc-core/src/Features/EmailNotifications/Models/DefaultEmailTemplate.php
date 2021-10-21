<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Models;

use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailContentContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailTemplateContract;

/**
 * This class will load the structured content from a default MJML template file.
 *
 * @since 2.15.0
 */
class DefaultEmailTemplate extends AbstractFileEmailContent implements EmailTemplateContract
{
    /** @var EmailContentContract */
    protected $innerContentTemplate;

    /** @var string identifier */
    protected $id = 'default';

    /** @var string name */
    protected $name = 'default';

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setLabel(_x('Default', 'name of the default email notification template', 'mwc-core'));
    }

    /**
     * Gets the structured content.
     *
     * @since 2.15.0
     *
     * @return string
     */
    public function getStructuredContent(): string
    {
        $innerContentTemplate = $this->getInnerContentTemplate();

        return StringHelper::replaceFirst(
            $this->getContentFromFile(),
            '{{content}}',
            $innerContentTemplate ? $innerContentTemplate->getStructuredContent() : ''
        );
    }

    /**
     * Sets the inner content template.
     *
     * @since 2.15.0
     *
     * @param EmailContentContract $content
     * @return self
     */
    public function setInnerContentTemplate(EmailContentContract $content) : EmailTemplateContract
    {
        $this->innerContentTemplate = $content;

        return $this;
    }

    /**
     * Gets the inner content template.
     *
     * @since 2.15.0
     *
     * @return EmailContentContract|null
     */
    public function getInnerContentTemplate()
    {
        return $this->innerContentTemplate;
    }
}
