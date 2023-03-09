<?php

/**
 ** get_avatar.php
 ** @version 1.2.1
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

$usr = new WP_User;
$current_user = $usr->wp_get_current_user();
$get__commenter__indx__bfr = null;
$get__commenter__indx__aft = null;
$get__commenter__indx__vrf = 0;
//$get__commenter__indx = 0;

function cpa__start__values()
{
    global $current_user, $get__commenter__indx;
    $get__commenter__indx = 0;
}
add_action("init", "cpa__start__values");

function cpa__get__old($id)
{
    $args = get_avatar_data($id);
    $url = $args['url'];
    return $url;
}

function cpa__change__avatar()
{
    global $current_user;
    if (!get_user_meta($current_user->id, 'custom_profile_avatar')) {
        add_user_meta($current_user->id, 'custom_profile_avatar', filter_input(INPUT_POST, 'avatar__val', FILTER_SANITIZE_URL));
    } else {
        update_user_meta($current_user->id, 'custom_profile_avatar', filter_input(INPUT_POST, 'avatar__val', FILTER_SANITIZE_URL));
    }
}

function cpa__get__avatar__new()
{
    global $current_user;
    if (empty(get_user_meta($current_user->id, 'custom_profile_avatar')[0]) || !get_user_meta($current_user->id, 'custom_profile_avatar')[0]) {
        $out = get_avatar($current_user->id, 110);
    } else {
        $out = '<img class="avatar" src="' . get_user_meta($current_user->id, 'custom_profile_avatar')[0] . '" /><div class="remove"></div>';
    }
    $out .= '<div id="pull" class="hidden"><img src="' .  cpa__get__old($current_user->id) . '" /></div>';
    return $out;
}

function cpa__get__value()
{
    global $current_user;
    if (get_user_meta($current_user->id, 'custom_profile_avatar')[0])
        return get_user_meta($current_user->id, 'custom_profile_avatar')[0];
    else
        return 0;
}

function compare__comment__id($a, $b)
{
    //echo $a->comment_ID . " " . $b->comment_ID;
    if ($a->comment_ID == $b->comment_ID) {
        return 0;
    }
    return ($a->comment_ID < $b->comment_ID) ? -1 : 1;
}

if (!function_exists('get_current_screen')) {
    require_once ABSPATH . '/wp-admin/includes/screen.php';
}

if (!class_exists('WP_Screen')) {
    require_once ABSPATH . '/wp-admin/includes/class-wp-screen.php';
}

if (!function_exists('get_avatar')) {
    function get_avatar($id_or_email, $size = 96, $default = '', $alt = '', $args = null)
    {
        $defaults = array(
            'size'          => 96,
            'height'        => null,
            'width'         => null,
            'default'       => get_option('avatar_default', 'mystery'),
            'force_default' => false,
            'rating'        => get_option('avatar_rating'),
            'scheme'        => null,
            'alt'           => '',
            'class'         => null,
            'force_display' => false,
            'loading'       => null,
            'extra_attr'    => '',
        );

        global $wp_version;

        if ($wp_version >= "5.5.0") {
            if (wp_lazy_loading_enabled('img', 'get_avatar')) {
                $defaults['loading'] = 'lazy';
            }
        }

        if (empty($args)) {
            $args = array();
        }

        $args['size']    = (int) $size;
        $args['default'] = $default;
        $args['alt']     = $alt;

        $args = wp_parse_args($args, $defaults);

        if (empty($args['height'])) {
            $args['height'] = $args['size'];
        }
        if (empty($args['width'])) {
            $args['width'] = $args['size'];
        }

        if (is_object($id_or_email) && isset($id_or_email->comment_ID)) {
            $id_or_email = get_comment($id_or_email);
        }

        $avatar = apply_filters('pre_get_avatar', null, $id_or_email, $args);

        if (!is_null($avatar)) {
            return apply_filters('get_avatar', $avatar, $id_or_email, $args['size'], $args['default'], $args['alt'], $args);
        }

        if (!$args['force_display'] && !get_option('show_avatars')) {
            return false;
        }

        $args = get_avatar_data($id_or_email, $args);
        $user = $id_or_email;
        $usr__id = $user->user_id;

        //
        $usr = get_userdata($user);
        $roles = $usr->roles;

        global $post;
        global $get__commenter__indx, $get__commenter__indx__bfr, $get__commenter__indx__aft, $get__commenter__indx__vrf;

        $comments__author__id__array = array();
        $comments__id__array = array();
        $getCommentArr = array();

        if (is_admin() && isset($_GET["p"])) {
            $getCommentArr["post_id"] = $_GET["p"];
        }

        if (is_single() || is_page() || is_singular()) {
            $get__comments = get_comments(array('post_id' => $post->ID, "status" => "approve"));
            usort($get__comments, 'compare__comment__id');
        } else if (is_admin() && isset($_GET['user_id'])) {
            $get__comments = get_comments($getCommentArr = array('user_id' => $_GET['user_id']));
        } else if (is_admin() && $_GET['comment_status'] == "moderated") {
            $getCommentArr["status"] = "hold";
            $get__comments = get_comments($getCommentArr);
        } else if (is_admin() && $_GET['comment_status'] == "trash") {
            $getCommentArr["status"] = "trash";
            $get__comments = get_comments($getCommentArr);
        } else if (is_admin() && $_GET['comment_status'] == "spam") {
            $getCommentArr["status"] = "spam";
            $get__comments = get_comments($getCommentArr);
        } else if (is_admin() && $_GET['comment_status'] == "approved") {
            $getCommentArr["status"] = "approve";
            $get__comments = get_comments($getCommentArr);
        } else {
            $get__comments = get_comments();
        }


        $get__parent__id__arr = array();
        foreach ($get__comments as $get__comment) {
            array_push($get__parent__id__arr, $get__comment->comment_parent);
        }
        $get__parent__id__arr__cln = $get__parent__id__arr;


        $indx__getting__comments = 0;
        foreach ($get__comments as $get__comment) {

            $comment__id = $get__comment->comment_ID;
            $comment__author__id = get_comment($comment__id)->user_id;

            $get__comment__parent_id = get_comment($comment__id)->comment_parent;
            $pos__for__arr = array_search($get__comment__parent_id, $comments__id__array);


            if ((($get__comment__parent_id < 1 && $get__comment->comment_approved == "1") || (!is_single() && !is_page() && !is_singular()))) {


                if (get_option("comment_order") === "asc") :
                    array_push($comments__id__array, $comment__id);
                    array_push($comments__author__id__array, $comment__author__id);
                elseif (get_option("comment_order") === "desc") :
                    array_unshift($comments__id__array, $comment__id);
                    array_unshift($comments__author__id__array, $comment__author__id);
                endif;
            } else if (get_comment($get__comment__parent_id)->comment_approved == "1" && $get__comment->comment_approved == "1") {


                if (is_single() || is_page() || is_singular()) {

                    $get__parent__id__arr__del = array_search($get__comment__parent_id, $get__parent__id__arr);
                    $get__parent__id__arr__cnt = array_count_values($get__parent__id__arr)[$get__comment__parent_id];
                    $get__parent__id__arr__cln__cnt = array_count_values($get__parent__id__arr__cln)[$get__comment__parent_id];



                    if ($get__parent__id__arr__cln__cnt > 1) {


                        $gttng__pos = $get__parent__id__arr__cln__cnt - $get__parent__id__arr__cnt + 1;


                        $comments__author__id__array = array_merge(array_slice($comments__author__id__array, 0, $pos__for__arr + $gttng__pos), array($comment__author__id), array_slice($comments__author__id__array, $pos__for__arr + $gttng__pos));

                        $comments__id__array = array_merge(array_slice($comments__id__array, 0, $pos__for__arr + $gttng__pos), array($comment__id), array_slice($comments__id__array, $pos__for__arr + $gttng__pos));

                        unset($get__parent__id__arr[$get__parent__id__arr__del]);
                    } else {


                        $comments__author__id__array = array_merge(array_slice($comments__author__id__array, 0, $pos__for__arr + 1), array($comment__author__id), array_slice($comments__author__id__array, $pos__for__arr + 1));

                        $comments__id__array = array_merge(array_slice($comments__id__array, 0, $pos__for__arr + 1), array($comment__id), array_slice($comments__id__array, $pos__for__arr + 1));
                    }
                } else {
                    $comments__author__id__array = array_merge(array_slice($comments__author__id__array, 0, $pos__for__arr + 1), array($comment__author__id), array_slice($comments__author__id__array, $pos__for__arr + 1));

                    $comments__id__array = array_merge(array_slice($comments__id__array, 0, $pos__for__arr + 1), array($comment__id), array_slice($comments__id__array, $pos__for__arr + 1));
                }
            }


            $indx__getting__comments++;
        }

        if (preg_match("/(comment-page-)([0-9])/i", $_SERVER["REQUEST_URI"], $getUrlEl) && get_option('page_comments') == 1 && $get__commenter__indx == 0 && get_option('default_comments_page') === "oldest") {
            $get__commenter__indx += (array_search(get_comment_ID(), $comments__id__array));
        } else if (get_option('default_comments_page') === "newest") {
            $get__commenter__indx = 0;
            $get__commenter__indx += (array_search(get_comment_ID(), $comments__id__array));
        }


        $commenter__user = get_userdata($comments__author__id__array[$get__commenter__indx]);
        $commenter__role = $commenter__user->roles;


        $spcfc__admn__pg = 0;
        if (is_admin() && (get_current_screen()->id === "edit-comments" || get_current_screen()->id === "dashboard")) {
            $spcfc__admn__pg = 1;
        }


        $cpa__WPScreen = WP_Screen::get();

        $option = $cpa__WPScreen->get_option('per_page', 'option');
        if (!$option) {
            $option = str_replace('-', '_', "{$cpa__WPScreen->id}_per_page");
        }
        $per_page = (int) get_user_option($option);
        if (empty($per_page) || $per_page < 1) {
            $per_page = $cpa__WPScreen->get_option('per_page', 'default');
            if (!$per_page) {
                $per_page = 20;
            }
        }
        $comment_status = isset($_REQUEST['comment_status']) ? $_REQUEST['comment_status'] : 'all';
        $per_page = apply_filters('comments_per_page', $per_page, $comment_status);


        if (is_admin() && $_GET["paged"] > 1 && get_current_screen()->id === "edit-comments" && ($_GET["paged"] - 1) * $per_page > $get__commenter__indx) {
            $chng__pos = $_GET["paged"];
            $get__commenter__indx = 0;
            while ($chng__pos > 1) {
                $get__commenter__indx += (get_user_meta(get_current_user_id(), 'custom_profile_avatar')[0]) ? $per_page : ($per_page);
                $chng__pos--;
            }
        }


        if (get_user_meta($usr__id, 'custom_profile_avatar')[0] && (get_option("custom_profile_avatar__options__permissions")[$roles[0]] == "on" || $roles[0] == "administrator")) {
            $custom__avatar = get_user_meta($usr__id, 'custom_profile_avatar')[0];
        } else if (get_user_meta($id_or_email, 'custom_profile_avatar')[0] && (get_option("custom_profile_avatar__options__permissions")[$roles[0]] == "on" || $roles[0] == "administrator")) {
            $custom__avatar = get_user_meta($id_or_email, 'custom_profile_avatar')[0];
        } else if (!get_comment_ID()) {
            $url = $args['url'];
            if (!$url || is_wp_error($url)) {
                return false;
            }
            $custom__avatar = $url;
        } else if (get_user_meta($comments__author__id__array[$get__commenter__indx], 'custom_profile_avatar')[0] && (get_option("custom_profile_avatar__options__permissions")[$commenter__role[0]] == "on" || $commenter__role[0] == "administrator") && (is_single() || is_page() || is_singular() || $spcfc__admn__pg == 1)) {

            if (get_comment_ID() > 0 && $get__commenter__indx < 0) {
                $get__commenter__indx++;
            }

            $custom__avatar = get_user_meta($comments__author__id__array[$get__commenter__indx], 'custom_profile_avatar')[0];

            if (is_single() || is_page() || is_singular() || get_current_screen()->id === "dashboard") {
                if (get_comment_ID() > 0) {
                    $get__commenter__indx++;
                }
            } else {
                $get__commenter__indx__bfr = $get__commenter__indx;

                if ($get__commenter__indx > 0) {

                    if (($get__commenter__indx__bfr % 2 != 0 && $get__commenter__indx__aft % 2 == 0) || $get__commenter__indx__vrf == 0) {
                        $get__commenter__indx__vrf = 1;
                    } else {
                        $get__commenter__indx__vrf = 0;
                    }
                }

                if ($get__commenter__indx__vrf != 1) {
                    $get__commenter__indx++;
                }

                $get__commenter__indx__aft = $get__commenter__indx;
            }
        } else {
            $url = $args['url'];
            if (!$url || is_wp_error($url)) {
                return false;
            }
            $custom__avatar = $url;

            if (get_comment_ID() > 0 && $get__commenter__indx < 0) {
                $get__commenter__indx++;
            }

            if (is_single() || is_page() || is_singular() || get_current_screen()->id === "dashboard") {
                if (get_comment_ID() > 0) {
                    $get__commenter__indx++;
                }
            } else {
                $get__commenter__indx__bfr = $get__commenter__indx;

                if ($get__commenter__indx > 0) {

                    if (($get__commenter__indx__bfr % 2 != 0 && $get__commenter__indx__aft % 2 == 0) || $get__commenter__indx__vrf == 0) {
                        $get__commenter__indx__vrf = 1;
                    } else {
                        $get__commenter__indx__vrf = 0;
                    }
                }

                if ($get__commenter__indx__vrf != 1) {
                    $get__commenter__indx++;
                }

                $get__commenter__indx__aft = $get__commenter__indx;
            }
        }

        $class = array('avatar', 'avatar-' . (int) $args['size'], 'photo');

        if (!$args['found_avatar'] || $args['force_default']) {
            $class[] = 'avatar-default';
        }

        if ($args['class']) {
            if (is_array($args['class'])) {
                $class = array_merge($class, $args['class']);
            } else {
                $class[] = $args['class'];
            }
        }

        $extra_attr = $args['extra_attr'];
        $loading    = $args['loading'];

        if (in_array($loading, array('lazy', 'eager'), true) && !preg_match('/\bloading\s*=/', $extra_attr)) {
            if (!empty($extra_attr)) {
                $extra_attr .= ' ';
            }

            $extra_attr .= "loading='{$loading}'";
        }

        $avatar = sprintf(
            "<img alt='%s' src='%s' class='%s' height='%d' width='%d' %s/>",
            esc_attr($args['alt']),
            $custom__avatar,
            esc_attr(implode(' ', $class)),
            (int) $args['height'],
            (int) $args['width'],
            $extra_attr
        );

        return apply_filters('get_avatar', $avatar, $id_or_email, $args['size'], $args['default'], $args['alt'], $args);
    }
}
