<?php

/**
 ** chooser.php
 ** @version 1.0
 ** @author en0ndev
 */
/*
This file is part of Custom Profile Avatar.

Plugin Name: Custom Profile Avatar
Plugin URI: http://wordpress.org/plugins/
Description: Change profile avatar to your custom avatar.
Author: en0ndev
Version: 1.0
Author URI: https://github.com/en0ndev

Custom Profile Avatar is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Custom Profile Avatar is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Custom Profile Avatar.  If not, see <https://www.gnu.org/licenses/>.
*/
defined('ABSPATH') || exit; // Exit if accessed directly

function choose__avatar()
{
    $src = plugin_dir_url(__FILE__) . '../assets/js/modules.js';
    //Core media script
    wp_enqueue_media();
    // Your custom js file
    wp_register_script('media-lib-uploader-js-avatar', $src, array('jquery'));
    wp_enqueue_script('media-lib-uploader-js-avatar');
}
add_action('admin_enqueue_scripts', 'choose__avatar');
