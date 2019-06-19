<?php
/**
 * Class for registering WordPress custom taxonomies
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

class Taxonomies extends WordPress implements WordPressAPIContract
{
    /**
     * Register the taxonomies with WordPress
     *
     * @since 1.0.0
     * @return this
     */
    public function register()
    {
        foreach ($this->config as $config) {
            foreach ($config['supports'] as $object_type) {
                register_taxonomy(
                    $config['id'],
                    $object_type,
                    $config
                );
            }
        }
        return $this;
    }
    /**
     * Add taxonomies to WordPress through hook API
     *
     * @since 1.0.0
     * @return void
     */
    public function add()
    {
        app('events')->addAction('init', [$this, 'register']);
    }
}
