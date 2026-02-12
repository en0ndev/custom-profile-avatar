<?php

/**
 ** profile_avatar.php
 ** @version 1.4
 ** @since 1.4
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

function cpa__can__edit__profile__avatar($target_user_id)
{
    $current_user_id = get_current_user_id();
    $is_admin = user_can($current_user_id, 'administrator');

    if (!current_user_can('edit_user', $target_user_id)) {
        return false;
    }

    if ((int) $target_user_id !== (int) $current_user_id) {
        return $is_admin;
    }

    return $is_admin || cpa__user__can__manage__avatar($target_user_id);
}

function cpa__enqueue__profile__avatar__assets($hook_suffix)
{
    if (!in_array($hook_suffix, array('profile.php', 'user-edit.php'), true)) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script(
        'cpa-profile-avatar-script',
        plugin_dir_url(__DIR__) . 'assets/js/profile_avatar.js',
        array('jquery'),
        '1.4',
        true
    );
}
add_action('admin_enqueue_scripts', 'cpa__enqueue__profile__avatar__assets');

function cpa__profile__avatar__styles()
{
    echo '<style>
    .cpa-profile-avatar-wrap { display:flex; align-items:center; gap:16px; margin-top:8px; }
    .cpa-profile-avatar-image { width:96px; height:96px; border-radius:50%; object-fit:cover; border:3px solid #fff; box-shadow:0 8px 16px rgba(0,0,0,.12); }
    .cpa-profile-avatar-actions { display:flex; flex-direction:column; gap:10px; }
    .cpa-profile-avatar-remove.button-link-delete { text-decoration:none; }
    </style>';
}
add_action('admin_head-profile.php', 'cpa__profile__avatar__styles');
add_action('admin_head-user-edit.php', 'cpa__profile__avatar__styles');

function cpa__render__profile__avatar__field($user)
{
    if (!($user instanceof WP_User)) {
        return;
    }

    if (!cpa__can__edit__profile__avatar($user->ID)) {
        return;
    }

    $custom_avatar = get_user_meta($user->ID, 'custom_profile_avatar', true);
    $fallback_avatar = cpa__get__old($user->ID, 'custom__avatar');
    $current_avatar = !empty($custom_avatar) ? $custom_avatar : $fallback_avatar;
    ?>
    <h2><?php echo esc_html__('Custom Profile Avatar', 'custom-profile-avatar'); ?></h2>
    <table class="form-table" role="presentation">
        <tr>
            <th><label for="cpa_profile_avatar"><?php echo esc_html__('Avatar', 'custom-profile-avatar'); ?></label></th>
            <td>
                <div class="cpa-profile-avatar-wrap" data-fallback="<?php echo esc_url($fallback_avatar); ?>">
                    <img
                        class="cpa-profile-avatar-image"
                        src="<?php echo esc_url($current_avatar); ?>"
                        alt="<?php echo esc_attr__('Current avatar', 'custom-profile-avatar'); ?>"
                    />
                    <div class="cpa-profile-avatar-actions">
                        <button type="button" class="button cpa-profile-avatar-change"><?php echo esc_html__('Choose Avatar', 'custom-profile-avatar'); ?></button>
                        <a href="#" class="cpa-profile-avatar-remove button-link-delete<?php echo empty($custom_avatar) ? ' hidden' : ''; ?>"><?php echo esc_html__('Remove custom avatar', 'custom-profile-avatar'); ?></a>
                    </div>
                </div>
                <input type="hidden" name="cpa_profile_avatar" id="cpa_profile_avatar" value="<?php echo esc_attr($custom_avatar); ?>" />
                <?php wp_nonce_field('cpa_profile_avatar_update', 'cpa_profile_avatar_nonce'); ?>
                <p class="description"><?php echo esc_html__('Upload a custom avatar for this user.', 'custom-profile-avatar'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'cpa__render__profile__avatar__field');
add_action('edit_user_profile', 'cpa__render__profile__avatar__field');

function cpa__save__profile__avatar__field($user_id)
{
    if (!isset($_POST['cpa_profile_avatar_nonce'])) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['cpa_profile_avatar_nonce']));
    if (!wp_verify_nonce($nonce, 'cpa_profile_avatar_update')) {
        return;
    }

    if (!cpa__can__edit__profile__avatar($user_id)) {
        return;
    }

    $avatar = isset($_POST['cpa_profile_avatar']) ? esc_url_raw(wp_unslash($_POST['cpa_profile_avatar'])) : '';
    update_user_meta($user_id, 'custom_profile_avatar', $avatar);
}
add_action('personal_options_update', 'cpa__save__profile__avatar__field');
add_action('edit_user_profile_update', 'cpa__save__profile__avatar__field');
