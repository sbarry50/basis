<?php
/**
 * Constants Contract
 *
 * @package    SB2Media\Basis\Contracts
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Basis\Contracts;

interface ConstantsContract
{

    /**
     * Define the plugin's constants
     *
     * @since  1.0.0
     * @return null
     */
    public function define();

    /**
     * Add additional constants to the default constants array
     *
     * @since 1.0.0
     * @return array    $this->constants    The plugin constants
     */
    public function add(array $constants);

    /**
     * Get the array of constants
     * @since  1.0.0
     * @return array    $this->constants    Plugin constants
     */
    public function get();
}
