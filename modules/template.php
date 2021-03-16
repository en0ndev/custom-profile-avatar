<?php

/**
 ** template.php
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

namespace template {
    class page__template
    {
        public static function get__template($title, $in, $form = false)
        {
            echo '<!DOCTYPE html>
            <head>
                <link rel="stylesheet" href="' . plugin_dir_url(__FILE__) . '../assets/css/style.css" />
            </head>
            <div class="main__area">' .
                htmlspecialchars_decode('<h2>') . esc_html__($title, 'custom-profile-avatar') . htmlspecialchars_decode('</h2>') .
                (($form) ? '<form method="POST" action="" >' : "") .
                '<div class="inner__area">' .
                $in .
                '</div>' .
                (($form) ? '</form>' : "") .
                '</div></html>';
        }
    }
}
