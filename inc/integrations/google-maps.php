<?php
/**
 * Google Maps Integration Helper Functions
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

if ( ! function_exists( 'webjti_get_gmaps_embed_url' ) ) {
    /**
     * Generate Google Maps Embed URL for a given address
     *
     * @param string $address Campus address
     * @return string Google Maps Embed URL
     */
    function webjti_get_gmaps_embed_url( $address ) {
        if ( empty( $address ) ) {
            return '';
        }
        return 'https://maps.google.com/maps?q=' . urlencode( $address ) . '&t=&z=15&ie=UTF8&iwloc=&output=embed';
    }
}
