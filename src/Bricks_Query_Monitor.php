<?php

namespace Bricks_Query_Monitor;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Bricks_Query_Monitor
 * @subpackage Bricks_Query_Monitor/includes
 * @author     Justin Vogt <mail@juvo-design.de>
 */
class Bricks_Query_Monitor
{

    const PLUGIN_NAME = 'bricks-query-monitor';

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin
     *
     * @var Loader
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @var string
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @var string
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct(string $version)
    {
        $this->version = $version;

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies(): void
    {

        $this->loader = new Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale(): void
    {

        $plugin_i18n = new i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     */
    private function define_admin_hooks(): void
    {

		// Add Setup Command
	    $this->loader->add_cli('setup', new Cli\Setup());

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks(): void
    {

        add_action('bricks/query/before_loop', function($query, $args): void {
            do_action('qm/start', "bricks_query_{$query->element_id}_{$query->object_type}");
        }, 10, 2);

        add_action('bricks/query/after_loop', function($query, $args): void {
            do_action('qm/stop', "bricks_query_{$query->element_id}_{$query->object_type}");
        }, 10, 2);

        add_filter('bricks/query/loop_object', function($loop_object, $loop_key, $query_obj) {
            do_action('qm/lap', "bricks_query_{$query_obj->element_id}_{$query_obj->object_type}");
            return $loop_object;
        }, 10, 3);
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run(): void
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name(): string
    {
        return self::PLUGIN_NAME;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader(): Loader
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     */
    public function get_version(): string
    {
        return $this->version;
    }

}
