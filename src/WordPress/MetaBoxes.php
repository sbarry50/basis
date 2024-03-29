<?php
/**
 * Class for registering WordPress meta boxes
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
use function SB2Media\Basis\config;

class MetaBoxes extends WordPress implements WordPressAPIContract
{
    /**
     * Constructor
     *
     * @since 1.0.0
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->filterClass();
    }

    /**
     * Register the meta boxes with WordPress
     *
     * @since 1.0.0
     * @return this
     */
    public function register()
    {
        foreach ($this->config as $config) {
            $callback = !empty($config['callback']) ? $config['callback'] : function ($args) use ($config) {
                $this->callback('meta-box', $config);
            };

            add_meta_box(
                $config['id'],
                $config['title'],
                $callback,
                $config['screen'],
                $config['context'],
                $config['priority'],
                $config['args']
            );
        }

        return $this;
    }

    /**
     * Add meta boxes to through WordPress through hook API
     *
     * @since 1.0.0
     * @return void
     */
    public function add()
    {
        app('events')->addAction('add_meta_boxes', [$this, 'register']);
    }

    /**
     * Callback function to route data to appropriate template for display
     *
     * @since 1.0.0
     * @param Array $config
     * @return void
     */
    protected function callback(string $view, array $config, bool $field = false)
    {
        $post_id = get_the_ID();

        $config['meta_fields'] = $this->getMetaFieldsByMetaBox($config['id']);
        
        foreach ($config['meta_fields'] as $key => &$val) {
            $val['value'] = get_post_meta($post_id, $val['id'], true);
        }

        wp_nonce_field("${config['id']}_nonce", "${config['id']}_nonce");

        parent::callback($view, $config);
    }

    /**
     * Emit filter event to add custom meta box class through WordPress hook system
     *
     * @since 1.0.0
     * @param Array $config
     * @return void
     */
    private function filterClass()
    {
        foreach ($this->config as $config) {
            app('events')->addFilter("postbox_classes_{$config['screen']}_{$config['id']}", [$this, 'addClass']);
        }
    }

    /**
     * Add custom-meta-box class to WP's postbox classes array
     *
     * @since 1.0.0
     * @param Array $classes
     * @return void
     */
    public function addClass($classes)
    {
        $classes[] = 'custom-meta-box';
        return $classes;
    }

    /**
     * Retrieve all the meta fields in a particular section
     *
     * @since 1.0.0
     * @param string $meta_box_id
     * @return array $section_meta_fields
     */
    private function getMetaFieldsByMetaBox(string $meta_box_id)
    {
        $meta_fields = config('meta-fields');
        $section_meta_fields = [];

        foreach ($meta_fields as $meta_field) {
            if ($meta_box_id === $meta_field['meta_box']) {
                $section_meta_fields[] = $meta_field;
            }
        }

        return $section_meta_fields;
    }
}
