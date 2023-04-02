<?php

/**
 ** get_styles.php
 ** @version 1.3
 ** @since 1.0
 ** @author en0ndev
 */
/*
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
defined('ABSPATH') || exit; // Exit if accessed directly

function cpa__get__style_css()
{
    $src = plugin_dir_url(__FILE__) . '../assets/css/style.css';
    wp_register_style('cpa-get-template', $src);
    wp_enqueue_style('cpa-get-template');
}

function cpa__get__style__js()
{
    $src = plugin_dir_url(__FILE__) . '../assets/js/modules.js';
    wp_enqueue_media();
    wp_register_script('cpa-media-lib-uploader-js', $src, array('jquery'));
    wp_enqueue_script('cpa-media-lib-uploader-js');
}

//

function cpa__get__ajax__data()
{
    wp_enqueue_script('cpa-ajax-script', plugin_dir_url(__DIR__) . 'assets/js/save_settings.js', array('jquery'));
    wp_localize_script('cpa-ajax-script', 'cpa__save__settings', array('ajax_url' => admin_url('admin-ajax.php')));

    wp_enqueue_script('cpa-ajax-script', plugin_dir_url(__DIR__) . 'assets/js/save_settings.js', array('jquery'));
    wp_localize_script('cpa-ajax-script', 'cpa__permission__settings', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_ajax_cpa__settings__change__avatar', "cpa__change__avatar");
add_action('wp_ajax_cpa__settings__change__permission', "cpa__set__permission");

//

$get_url = $_SERVER['QUERY_STRING'];
$keys = 'custom_profile_avatar';

if (strpos($get_url, $keys) == true) {
    add_action('admin_enqueue_scripts', 'cpa__get__style_css');
    add_action('admin_enqueue_scripts', 'cpa__get__style__js');
    add_action('admin_enqueue_scripts', 'cpa__get__ajax__data');
}
