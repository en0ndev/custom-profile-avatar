<?php

/**
 ** get_permissions.php
 ** @version 1.2.1
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

function cpa__set__check__box()
{
    $permission__settings = array(
        "editor" => ($_POST['editor__permission'] == "on") ? $_POST["editor__permission"] : "off",
        "author" => ($_POST['author__permission'] == "on") ? $_POST["author__permission"] : "off",
        "contributor" => ($_POST['contributor__permission'] == "on") ? $_POST["contributor__permission"] : "off",
        "shop_manager" => ($_POST['shopm__permission'] == "on") ? $_POST["shopm__permission"] : "off",
    );

    if (get_option("custom_profile_avatar__options__permissions")) {
        update_option("custom_profile_avatar__options__permissions", $permission__settings);
    } else {
        add_option("custom_profile_avatar__options__permissions", $permission__settings);
    }
}

add_action('admin_init', 'cpa__allow__contributor__uploads');
function cpa__allow__contributor__uploads()
{
    $contributor = get_role('contributor');
    if (get_option("custom_profile_avatar__options__permissions")["contributor"] == "on" && !$contributor->has_cap("upload_files")) {
        $contributor->add_cap('upload_files');
    } else if (get_option("custom_profile_avatar__options__permissions")["contributor"] == "off" && $contributor->has_cap("upload_files")) {
        $contributor->remove_cap('upload_files');
    }
}

function cpa__get__check__box($getDataNameForBox)
{
    $getDataArrOption =  get_option("custom_profile_avatar__options__permissions")[$getDataNameForBox];
    if ($getDataArrOption == "on") {
        return "checked='checked'";
    }
}
