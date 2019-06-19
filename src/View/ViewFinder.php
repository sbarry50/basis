<?php
/**
 * View composer class
 *
 * @package    SB2Media\Basis\View
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Basis\View;

use InvalidArgumentException;
use SB2Media\Basis\File\Loader;
use function SB2Media\Basis\app;
use function SB2Media\Basis\url;
use function SB2Media\Basis\path;

class ViewFinder
{
    /**
     * Find the view file, pass it the configuration and render the output
     *
     * @since 1.0.0
     * @param string $filename
     * @param array $config
     * @param boolean $field
     * @return void
     */
    public function render(string $filename, array $config = [], bool $field = false)
    {
        if ('image-upload' == $filename) {
            $config = $this->imageUploadFilter($config);
        }

        $locations = ['plugin', 'framework'];

        foreach ($locations as $location) {
            $file = $this->viewFilePath($filename, $field, $location);

            if (file_exists($file) && is_readable($file)) {
                echo Loader::loadOutputFile($file, $config);
                break;
            }
        }
    }

    /**
     * Get the fully qualified file path of the view in either the plugin or the framework.
     *
     * @since 1.0.0
     * @param string    $filename
     * @param boolean   $field
     * @param string    $location   Whether to check in plugin or framework view folder. Possible values 'plugin' or 'framework'
     * @return string
     */
    private function viewFilePath(string $filename, bool $field, string $location)
    {
        if ('plugin' === $location) {
            $path = path('views');
        } elseif ('framework' === $location) {
            $path = dirname(dirname(dirname(__FILE__))) . '/views/';
        } else {
            throw new InvalidArgumentException(__("'{$location}' is not a valid location argument. Allowed values are 'plugin' or 'framework'", app()->text_domain));
        }

        $path .= $field ? 'fields/' : '';
        
        return $path . $filename . '.php';
    }

    /**
     * Filter the arguments for an image upload
     *
     * @since 1.0.0
     * @param array $args
     * @return array
     */
    private function imageUploadFilter($args)
    {
        $width = array_key_exists('width', $args['args']) ? $args['args']['width'] : 150;
        $height = array_key_exists('height', $args['args']) ? $args['args']['height'] : 150;
        $id = $args['id'];
        $wp_img_id = array_key_exists('page', $args) ? get_option($id) : get_post_meta(get_the_ID(), $id, true);
        $default_image = url('resources/img', 'no-image.png');
    
        if (!empty($wp_img_id)) {
            $image_attributes = wp_get_attachment_image_src($wp_img_id, array($width * 2, $height * 2));
            $src = $image_attributes[0];
            $value = $wp_img_id;
        } else {
            $src = $default_image;
            $value = '';
        }
    
        $args = [
            'id'            => $id,
            'src'           => $src,
            'default_image' => $default_image,
            'width'         => $width,
            'height'        => $height,
            'value'         => $value,
        ];
    
        return $args;
    }
}
