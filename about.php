<?php

/**
 ** about.php
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

$template = "<div class='about'><img src='" . esc_url(plugin_dir_url(__FILE__) . "/assets/img/icon.png") . "' alt='Custom Profile Avatar' /><p class='big'>Custom Profile Avatar</p>";
$template .= "<p>" . esc_html__('Version', 'custom-profile-avatar') . ": 1.4</p>";
$template .= "<p>" . esc_html__('Developer', 'custom-profile-avatar') .  ": <a class='about__author link' href='https://en0n.dev/' target='_blank' rel='noopener noreferrer'>en0ndev</a></p>";
$template .= "<a class='link' target='_blank' rel='noopener noreferrer' href='https://www.youtube.com/@en0ndev'>" . esc_html__('My YouTube Channel', 'custom-profile-avatar') . "</a></div>";

$page = new cpa__page__template;

$page->cpa__get__template(__('About', 'custom-profile-avatar'), $template, 0);
