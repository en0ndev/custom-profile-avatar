<?php

/**
 ** admin_footer.php
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

function admin_footer($text)
{

    $get_url = $_SERVER['QUERY_STRING'];

    $keys = 'custom_profile_avatar';

    if (strpos($get_url, $keys) == true) {

        $text = '<span id="author__by"><a>Developed by </a><a class="bold" href="https://github.com/en0ndev" target="_blank">en0ndev</a></span>';
    }

    return $text;
}

add_filter('admin_footer_text', 'admin_footer');
