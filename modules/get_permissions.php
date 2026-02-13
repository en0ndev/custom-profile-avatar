<?php

/**
 ** get_permissions.php
 ** @since 1.1
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

function cpa__set__permission()
{
    if (!check_ajax_referer('cpa_change_permission_nonce', 'security', false)) {
        wp_send_json_error(array('state' => 0, 'message' => 'invalid_nonce'), 403);
    }

    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('state' => 0, 'message' => 'unauthorized'), 403);
    }

    $permission__settings = array(
        'editor' => (isset($_POST['editor__permission']) && wp_unslash($_POST['editor__permission']) === 'on') ? 'on' : 'off',
        'author' => (isset($_POST['author__permission']) && wp_unslash($_POST['author__permission']) === 'on') ? 'on' : 'off',
        'contributor' => (isset($_POST['contributor__permission']) && wp_unslash($_POST['contributor__permission']) === 'on') ? 'on' : 'off',
        'shop_manager' => (isset($_POST['shopm__permission']) && wp_unslash($_POST['shopm__permission']) === 'on') ? 'on' : 'off',
    );

    $disable__gravatar = (isset($_POST['disable__gravatar']) && wp_unslash($_POST['disable__gravatar']) === 'on') ? 'on' : 'off';
    $default_avatar = isset($_POST['avatar__val']) ? esc_url_raw(wp_unslash($_POST['avatar__val'])) : '';

    update_option('custom_profile_avatar__options__permissions', $permission__settings);
    update_option('custom_profile_avatar__options__disable__gravatar', $disable__gravatar);
    update_option('custom_profile_avatar__options__default__avatar', $default_avatar);

    wp_send_json_success(array('state' => 1));
}

add_action('admin_init', 'cpa__allow__contributor__uploads');
function cpa__allow__contributor__uploads()
{
    $contributor = get_role('contributor');
    if (!$contributor) {
        return;
    }

    if (isset(get_option("custom_profile_avatar__options__permissions")["contributor"])) :
        if (get_option("custom_profile_avatar__options__permissions")["contributor"] == "on" && !$contributor->has_cap("upload_files")) {
            $contributor->add_cap('upload_files');
        } else if (get_option("custom_profile_avatar__options__permissions")["contributor"] == "off" && $contributor->has_cap("upload_files")) {
            $contributor->remove_cap('upload_files');
        }
    endif;
}

function cpa__get__check__box__permission($getDataNameForBox)
{
    $getDataArrOption =  get_option("custom_profile_avatar__options__permissions")[$getDataNameForBox] ?? 0;
    if ($getDataArrOption == "on") {
        return " checked='checked'";
    }
}

//

function cpa__get__check__box__disable__gravatar()
{
    $getDataArrOption =  get_option("custom_profile_avatar__options__disable__gravatar") ?? 0;
    if ($getDataArrOption == "on") {
        return " checked='checked'";
    }
}
