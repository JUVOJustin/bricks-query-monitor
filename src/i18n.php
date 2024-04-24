<?php

namespace Bricks_Query_Monitor;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 */
class i18n {

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain(): void {

        load_plugin_textdomain(
            'bricks-query-monitor',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );

    }

}