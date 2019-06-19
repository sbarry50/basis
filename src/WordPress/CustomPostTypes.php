<?php
/**
 * Class for registering WordPress custom post types
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

class CustomPostTypes extends WordPress implements WordPressAPIContract
{
    /**
     * Register the custom post types with WordPress
     *
     * @since 1.0.0
     * @return this
     */
    public function register()
    {
        foreach ($this->config as $config) {
            register_post_type($config['id'], $config);
        }

        return $this;
    }

    /**
     * Add custom post types to WordPress through hook API
     *
     * @since 1.0.0
     * @return void
     */
    public function add()
    {
        app('events')->addAction('init', array($this, 'register'));
    }
}
