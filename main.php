<?php

/**
 ** main.php
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

$template  = "<div id='cpa__change__avatar' class='change__avatar'><h4 class='info__card'>Change your avatar</h4><div id='user__avatar' class='user__avatar'><input id='change' type='button'/><span></span>" . htmlspecialchars_decode(cpa__get__avatar__new("custom__avatar"));
$template .= "<input type='text' class='hidden' name='avatar__val' value='" . esc_attr(cpa__get__value("custom__avatar")) . "' /></div></div>";

$page = new cpa__page__template;

$page->cpa__get__template(__('Manage Avatar', 'custom-profile-avatar'), $template, 1);
