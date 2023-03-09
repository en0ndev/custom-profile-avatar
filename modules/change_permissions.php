<?php

/**
 ** change_permissions.php
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

if (isset($_POST['cpa__save__avatar'])) {
    try {
        cpa__set__check__box();
        echo '<div id="notf" class="scs">' . 'Permissions Successfully Saved!' . '</div>';
        echo '<script>location.reload();</script>';
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $msg .= '<div id="notf" class="err">' . 'Permissions Not Updated!' . '</div>';
        echo $msg;
    }
}
