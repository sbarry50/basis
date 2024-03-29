<?php
/**
 * Class for resolving the MediaDetails object type
 *
 * @package    SB2Media\BusinessInfo\Hours
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Basis\Media;

use SB2Media\Basis\Contracts\GraphQLResolverContract;
use function SB2Media\Basis\app;

class MediaDetailsGraphQL implements GraphQLResolverContract
{
    /**
     * Resolve the media details for GraphQL
     *
     * @since 1.0.0
     * @param array $config
     * @param string|array $value
     * @return void
     */
    public function resolve(array $config, $value)
    {
        $media_details = wp_get_attachment_metadata($value);
        $media_details['file'] = wp_get_attachment_url($value, 'full');
        $media_details['ID'] = $value;

        return $media_details;
    }
}
