<?php

/**
 ** get_avatar.php
 ** @version 1.0
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

$usr = new WP_User;
$current_user = $usr->wp_get_current_user();

function cpa__get__old($id)
{
    $args = get_avatar_data($id);
    $url = $args['url'];
    return $url;
}

function cpa__change__avatar()
{
    global $current_user;
    if (!get_user_meta($current_user->id, 'custom_profile_avatar')) {
        add_user_meta($current_user->id, 'custom_profile_avatar', filter_input(INPUT_POST, 'avatar__val', FILTER_SANITIZE_URL));
    } else {
        update_user_meta($current_user->id, 'custom_profile_avatar', filter_input(INPUT_POST, 'avatar__val', FILTER_SANITIZE_URL));
    }
}

function cpa__get__avatar__new()
{
    global $current_user;
    if (empty(get_user_meta($current_user->id, 'custom_profile_avatar')[0]) || !get_user_meta($current_user->id, 'custom_profile_avatar')[0]) {
        $out = get_avatar($current_user->id, 110);
    } else {
        $out = '<img class="avatar" src="' . get_user_meta($current_user->id, 'custom_profile_avatar')[0] . '" /><div class="remove"></div>';
    }
    $out .= '<div id="pull" class="hidden"><img src="' .  cpa__get__old($current_user->id) . '" /></div>';
    return $out;
}

function cpa__get__value()
{
    global $current_user;
    if (get_user_meta($current_user->id, 'custom_profile_avatar')[0])
        return get_user_meta($current_user->id, 'custom_profile_avatar')[0];
    else
        return 0;
}

if (!function_exists('get_avatar')) {
    function get_avatar($id_or_email, $size = 96, $default = '', $alt = '', $args = null)
    {
        $defaults = array(
            'size'          => 96,
            'height'        => null,
            'width'         => null,
            'default'       => get_option('avatar_default', 'mystery'),
            'force_default' => false,
            'rating'        => get_option('avatar_rating'),
            'scheme'        => null,
            'alt'           => '',
            'class'         => null,
            'force_display' => false,
            'loading'       => null,
            'extra_attr'    => '',
        );

        if (wp_lazy_loading_enabled('img', 'get_avatar')) {
            $defaults['loading'] = 'lazy';
        }

        if (empty($args)) {
            $args = array();
        }

        $args['size']    = (int) $size;
        $args['default'] = $default;
        $args['alt']     = $alt;

        $args = wp_parse_args($args, $defaults);

        if (empty($args['height'])) {
            $args['height'] = $args['size'];
        }
        if (empty($args['width'])) {
            $args['width'] = $args['size'];
        }

        if (is_object($id_or_email) && isset($id_or_email->comment_ID)) {
            $id_or_email = get_comment($id_or_email);
        }

        $avatar = apply_filters('pre_get_avatar', null, $id_or_email, $args);

        if (!is_null($avatar)) {
            return apply_filters('get_avatar', $avatar, $id_or_email, $args['size'], $args['default'], $args['alt'], $args);
        }

        if (!$args['force_display'] && !get_option('show_avatars')) {
            return false;
        }

        $args = get_avatar_data($id_or_email, $args);
        $user = $id_or_email;
        $usr__id = $user->user_id;

        if (get_user_meta($usr__id, 'custom_profile_avatar')[0]) {
            $custom__avatar = get_user_meta($usr__id, 'custom_profile_avatar')[0];
        } else if (get_user_meta($id_or_email, 'custom_profile_avatar')[0]) {
            $custom__avatar = get_user_meta($id_or_email, 'custom_profile_avatar')[0];
        } else {
            $url = $args['url'];
            if (!$url || is_wp_error($url)) {
                return false;
            }
            $custom__avatar = $url;
        }

        $class = array('avatar', 'avatar-' . (int) $args['size'], 'photo');

        if (!$args['found_avatar'] || $args['force_default']) {
            $class[] = 'avatar-default';
        }

        if ($args['class']) {
            if (is_array($args['class'])) {
                $class = array_merge($class, $args['class']);
            } else {
                $class[] = $args['class'];
            }
        }

        $extra_attr = $args['extra_attr'];
        $loading    = $args['loading'];

        if (in_array($loading, array('lazy', 'eager'), true) && !preg_match('/\bloading\s*=/', $extra_attr)) {
            if (!empty($extra_attr)) {
                $extra_attr .= ' ';
            }

            $extra_attr .= "loading='{$loading}'";
        }

        $avatar = sprintf(
            "<img alt='%s' src='%s' class='%s' height='%d' width='%d' %s/>",
            esc_attr($args['alt']),
            $custom__avatar,
            esc_attr(implode(' ', $class)),
            (int) $args['height'],
            (int) $args['width'],
            $extra_attr
        );

        return apply_filters('get_avatar', $avatar, $id_or_email, $args['size'], $args['default'], $args['alt'], $args);
    }
}
