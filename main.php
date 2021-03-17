<?php

/**
 ** main.php
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

$template  = "<div class='user__avatar'>" . htmlspecialchars_decode(cpa__get__avatar__new()) . "</div>";
$template .= "<input type='text' class='hidden' name='avatar__val' value='" . cpa__get__value() . "' />";
$template .= "<input id='change' type='button' value='" . esc_html__("Change Avatar") . "' /></div>";
$template .= "<input id='save' type='submit' name='cpa__save__avatar' value='" . esc_html__("Save") . "' />";

use cpa__template\cpa__page__template;

$page = new cpa__page__template;

$page->cpa__get__template("Settings", $template, 1);
