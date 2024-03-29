<?php
/**
 * Class that defines plugin activation/deactivation/uninstall callbacks.
 *
 * @package    SB2Media\Basis\Setup
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 *
 * Heavily based on this Stack Exchange Q&A
 * @author Franz Josef Kaiser/wecodemore
 * @link   https://wordpress.stackexchange.com/questions/25910/uninstall-activate-deactivate-a-plugin-typical-features-how-to/25979#25979
 */

namespace SB2Media\Basis\Setup;

use function SB2Media\Basis\app;

class Activation
{

    /**
     * Instance of the class
     *
     * @var object
     */
    protected static $instance;

    /**
     * Initialize the class
     *
     * @since  1.0.0
     * @return object
     */
    public static function init()
    {
        is_null(self::$instance) and self::$instance = new self;
        return self::$instance;
    }

    /**
     * Register the activation, deactivation and uninstall WordPress hooks
     *
     * @since  1.0.0
     * @param  $file    Plugin root file
     */
    public static function register($file)
    {
        $class = __NAMESPACE__ . '\Activation';
        register_activation_hook($file, array($class, 'activate'));
        register_deactivation_hook($file, array($class, 'deactivate'));
        register_uninstall_hook($file, array($class, 'uninstall'));
    }

    /**
     * Activation actions
     *
     * @since  1.0.0
     * @return null
     */
    public static function activate()
    {
        if (! current_user_can('activate_plugins')) {
            return;
        }

        $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
        check_admin_referer("activate-plugin_{$plugin}");

        flush_rewrite_rules();

        // Uncomment the following line to see the function in action
        // exit(var_dump($_GET));
    }

    /**
     * Deactivation actions
     *
     * @since  1.0.0
     * @return null
     */
    public static function deactivate()
    {
        if (! current_user_can('activate_plugins')) {
            return;
        }

        // This feels like a workaround. Produces "Are you sure you want to do this?" error if deactivated due to failed requirements check.
        if (app()->get('compatibility')->allCompatible()) {
            $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
            check_admin_referer("deactivate-plugin_{$plugin}");
        }

        // @link https://knowthecode.io/labs/custom-post-type-basics/episode-8
        // flush_rewrite_rules() results in weird behavior. Use this instead...
        delete_option('rewrite_rules');

        // Uncomment the following line to see the function in action
        // exit(var_dump($_GET));
    }

    /**
     * Uninstallation actions
     *
     * @since  1.0.0
     * @return null
     */
    public static function uninstall()
    {
        if (! current_user_can('activate_plugins')) {
            return;
        }

        check_admin_referer('bulk-plugins');

        // Important: Check if the file is the one
        // that was registered during the uninstall hook.
        if (__FILE__ != WP_UNINSTALL_PLUGIN) {
            return;
        }

        // Remove files and database tables here

        # Uncomment the following line to see the function in action
        # exit(var_dump($_GET));
    }
}
