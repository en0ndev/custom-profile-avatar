<?php

/**
 ** template.php
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

class cpa__page__template
{
    public static function cpa__get__template($title, $in, $form = false)
    {
        echo '<div class="main__area">' .
            htmlspecialchars_decode('<h2>') . esc_html__($title, 'custom-profile-avatar') . htmlspecialchars_decode('</h2>') .
            (($form) ? '<form method="POST" action="">' : "") .
            '<div class="inner__area">' .
            $in .
            '</div>' .
            (($form) ? '<input id="save" type="submit" name="cpa__save__avatar" value=' . esc_html__('Save', 'custom-profile-avatar') . ' />' : "") .
            (($form) ? '</form>' : "") .
            '<div class="rate__box"><a target="_blank" href="https://wordpress.org/support/plugin/custom-profile-avatar/reviews/#new-post">' . esc_html__("If you like Custom Profile Avatar, please rate it.", "custom-profile-avatar") .  '</a></div>' .
            '</div>';
    }
}
