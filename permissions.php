<?php

/**
 ** permissions.php
 ** @version 1.1
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

$template  = "<div class='user__permissions'>";
$template .= "<h4 class='info__card'>Choose who can change the avatar</h4>";
$template .= "<div class='checkbox__area'><label class='permission__cont'><input type='checkbox' name='editor__permission'" . cpa__get__check__box("editor") . "/><span>Editor</span></label>";
$template .= "<label class='permission__cont'><input type='checkbox' name='author__permission'" . cpa__get__check__box("author") . "/><span>Author</span></label>";
$template .= "<label class='permission__cont'><input type='checkbox' name='contributor__permission'" . cpa__get__check__box("contributor") . "/><span>Contributor</span></label>";
$template .= "<label class='permission__cont'><input type='checkbox' name='shopm__permission'" . cpa__get__check__box("shop_manager") . "/><span>Shop Manager</span></label></div>";
$template .= "</div>";

$page = new cpa__page__template;

$page->cpa__get__template(__('Permissions', 'custom-profile-avatar'), $template, 1);
