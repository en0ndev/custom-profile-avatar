<?php

/**
 ** menu_setup.php
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

function add__menus()
{

    $img = plugin_dir_url(__FILE__) . '../assets/img/icon.png';

    add_menu_page(
        __('Avatar Settings', 'custom_profile_avatar'),
        __('Custom Profile Avatar', 'custom_profile_avatar'),
        'manage_options',
        'custom_profile_avatar',
        'main__settings',
        $img,
        59
    );

    add_submenu_page(
        'custom_profile_avatar',
        'Custom Profile Avatar',
        'Settings',
        'manage_options',
        'custom_profile_avatar',
        'main__settings'
    );

    add_submenu_page(
        'custom_profile_avatar',
        'About',
        'About',
        'manage_options',
        'custom_profile_avatar_about',
        'about__author'
    );
}
add_action('admin_menu', 'add__menus');
