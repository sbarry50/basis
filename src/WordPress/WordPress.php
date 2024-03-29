<?php
/**
 * Abstract class for interacting with WordPress' various API's to extend its base functionality
 *
 * @package    SB2Media\Basis\WordPress
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Basis\WordPress;

use SB2Media\Basis\Contracts\WordPressAPIContract;
use function SB2Media\Basis\app;

abstract class WordPress implements WordPressAPIContract
{
    /**
     * Functionality Configuration
     *
     * @since 1.0.0
     * @var array $config
     */
    public $config;

    /**
     * Constructor
     *
     * @since 1.0.0
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->add();
    }

    /**
     * Register the functionality through one of WordPress' API's
     *
     * @since 1.0.0
     * @return this
     */
    abstract public function register();

    /**
     * Add extended functionality to WordPress through hook API
     *
     * @since 1.0.0
     * @return void
     */
    abstract public function add();

    /**
     * Callback function to route data to appropriate template for display
     *
     * @since 1.0.0
     * @param String $view    View template to call
     * @param Array  $config  Functionality configuration
     * @return void
     */
    protected function callback(string $view, array $config, bool $field = false)
    {
        app('views')->render($view, $config, $field);
    }
}
