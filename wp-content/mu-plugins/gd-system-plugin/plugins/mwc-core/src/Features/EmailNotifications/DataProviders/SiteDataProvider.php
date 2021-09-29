<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\DataProviders;

use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\DataProviderContract;
use WC_Emails;

/**
 * A provider for email notifications to handle data for site-related merge tags.
 *
 * @see WC_Emails::replace_placeholders() for reference
 */
class SiteDataProvider implements DataProviderContract
{
    /**
     * Gets site data.
     *
     * @return array
     */
    public function getData() : array
    {
        $domain = $this->getSiteDomain();

        return [
            'site_address' => $domain,
            'site_title'   => $this->getSiteTitle(),
            'site_url'     => $domain,
        ];
    }

    /**
     * Gets site placeholders.
     *
     * @return string[]
     */
    public function getPlaceholders() : array
    {
        return array_keys($this->getData());
    }

    /**
     * Gets site preview data.
     *
     * @return array
     */
    public function getPreviewData() : array
    {
        return $this->getData();
    }

    /**
     * Gets the site domain.
     *
     * TODO: consider moving this into a configuration and the WordPressRepository {@cwiseman 2021-09-17}
     *
     * @return string
     */
    protected function getSiteDomain() : string
    {
        return (string) wp_parse_url(home_url(), PHP_URL_HOST) ?: '';
    }

    /**
     * Gets the site title.
     *
     * TODO: consider moving this into a configuration and the WordPressRepository {@cwiseman 2021-09-17}
     *
     * @return string
     */
    protected function getSiteTitle() : string
    {
        return (string) get_bloginfo('name') ?: '';
    }
}
