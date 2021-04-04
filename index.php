<?php

/*
Plugin Name: Custom Profile Avatar
Plugin URI: https://wordpress.org/plugins/custom-profile-avatar
Description: Change profile avatar to your custom avatar.
Version: 1.0.2
Author: en0ndev
Author URI: https://github.com/en0ndev
Text Domain: custom-profile-avatar

This file is part of Custom Profile Avatar.

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

require_once __DIR__ . '/modules/menu_setup.php';
require_once __DIR__ . '/modules/admin_menu_join.php';
require_once __DIR__ . '/modules/admin_footer.php';
require_once __DIR__ . '/modules/template.php';
require_once __DIR__ . '/modules/get_avatar.php';
require_once __DIR__ . '/modules/get_styles.php';

/*function cpa_load_textdomain()
{
    load_plugin_textdomain('custom-profile-avatar', false, basename(dirname(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'cpa_load_textdomain');*/
