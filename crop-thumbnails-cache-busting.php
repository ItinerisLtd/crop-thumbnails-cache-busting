<?php

declare(strict_types=1);

/**
 * Plugin Name:     Crop Thumbnails CDN Cache Busting
 * Plugin URI:      https://www.itineris.co.uk/
 * Description:     Changes the filename on crop to prevent CDN caching issues
 * Version:         0.1.0
 * Author:          Itineris Limited
 * Author URI:      https://www.itineris.co.uk/
 * Text Domain:     itineris
 */

namespace Itineris\CropThumbnailsCacheBusting;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

add_filter('crop_thumbnails_before_update_metadata', function (array $metadata, int $attachment_id): array {
    /** @var \Amazon_S3_And_CloudFront_Pro $as3cfpro */
    global $as3cfpro;

    if ($as3cfpro instanceof \Amazon_S3_And_CloudFront_Pro
        && true === $as3cfpro->download_attachment_from_provider($attachment_id)
    ) {
        $as3cfpro->delete_attachment($attachment_id);
    }

    return $metadata;
}, 10, 2);
