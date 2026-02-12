<?php

/**
 ** menu_setup.php
 ** @version 1.4
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

function cpa__wp__menu__svg__icon()
{
    static $icon = null;
    if ($icon !== null) {
        return $icon;
    }

    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><circle cx="10" cy="6.5" r="3.2" fill="currentColor"/><path d="M3.6 17c.9-3.3 3.6-5.3 6.4-5.3s5.5 2 6.4 5.3" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>';
    $icon = 'data:image/svg+xml;base64,' . base64_encode($svg);

    return $icon;
}

function cpa__add__menus()
{
    cpa__add__menu__permission();
}
add_action('admin_menu', 'cpa__add__menus');

function cpa__add__menu__permission()
{
    $usr_id = get_current_user_id();
    $usr = get_userdata($usr_id);
    if (!$usr) {
        return;
    }

    if (cpa__user__can__manage__avatar($usr_id)) {

        $img = cpa__wp__menu__svg__icon();
        add_menu_page(
            __('Avatar Settings', 'custom_profile_avatar'),
            __('Custom Profile Avatar', 'custom_profile_avatar'),
            'edit_posts',
            'custom_profile_avatar',
            'cpa__main__settings',
            $img,
            59
        );
        add_submenu_page(
            'custom_profile_avatar',
            'Custom Profile Avatar',
            esc_html__('Manage Avatar', 'custom-profile-avatar'),
            'edit_posts',
            'custom_profile_avatar',
            'cpa__main__settings'
        );

        add_submenu_page(
            'custom_profile_avatar',
            esc_html__('Manage Permissions', 'custom-profile-avatar'),
            esc_html__('Manage Permissions', 'custom-profile-avatar'),
            'manage_options',
            'custom_profile_avatar_permissions',
            'cpa__manage__permissions'
        );

        add_submenu_page(
            'custom_profile_avatar',
            esc_html__('About', 'custom-profile-avatar'),
            esc_html__('About', 'custom-profile-avatar'),
            'edit_posts',
            'custom_profile_avatar_about',
            'cpa__about__author'
        );
    }
}
