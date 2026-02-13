<?php

/**
 ** template.php
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
        $output = '<div class="main__area">';
        $output .= '<h2>' . esc_html($title) . '</h2>';
        $output .= $form ? '<form method="POST" action="">' : '';
        $output .= '<div class="inner__area">' . $in . '</div>';
        $output .= $form
            ? '<input id="save" type="submit" name="cpa__save__avatar" value="' . esc_attr__('Save', 'custom-profile-avatar') . '" />'
            : '';
        $output .= $form ? '</form>' : '';
        $output .= '<div class="rate__box"><a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/support/plugin/custom-profile-avatar/reviews/#new-post">' . esc_html__('If you like Custom Profile Avatar, please rate it.', 'custom-profile-avatar') . '</a></div>';
        $output .= '</div>';

        echo $output;
    }
}
