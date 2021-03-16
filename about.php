<?php

/**
 ** about.php
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

$template = "<div class='about'><p class='big'>Custom Profile Avatar</p>";
$template .= "<p>Version: 1.0</p>";
$template .= "<p>Developer: en0ndev</p>";
$template .= "<a target='_blank' href='https://www.youtube.com/channel/UC3CSOAThanO-LvYKFwJ24RQ'>My YouTube Channel</a></div>";

use template\page__template;

$page = new page__template;

$page->get__template("About", $template, 0);
