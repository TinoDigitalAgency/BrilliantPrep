<?php

namespace GoDaddy\WordPress\MWC\Common\Repositories\WordPress;

use wpdb;

/**
 * Repository handler for WordPress database handling.
 *
 * @since 3.4.1
 */
class DatabaseRepository
{
    /**
     * Gets the WordPress DataBase handler instance.
     *
     * @since 3.4.1
     *
     * @return wpdb
     */
    public static function instance() : wpdb
    {
        global $wpdb;

        return $wpdb;
    }
}
