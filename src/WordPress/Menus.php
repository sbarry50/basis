<?php
/**
 * Class for registering WordPress administration menus
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

class Menus extends WordPress implements WordPressAPIContract
{
    /**
     * Register the menus with WordPress
     *
     * @since 1.0.0
     * @return this
     */
    public function register()
    {
        foreach ($this->config as $config) {
            $callback = !empty($config['callback']) ? $config['callback'] : function () use ($config) {
                $this->callback('menu-page', $config);
            };

            add_menu_page(
                $config['page_title'],
                $config['menu_title'],
                $config['capability'],
                $config['menu_slug'],
                $callback,
                $config['icon_url'],
                $config['position']
            );
        }
    }

    /**
     * Add menus to WordPress through hook API
     *
     * @since 1.0.0
     * @return void
     */
    public function add()
    {
        app('events')->addAction('admin_menu', array($this, 'register'));
    }
}
