/**
** File: modules.js
** Version: 1.2.1
** Since: 1.0
** Author: en0ndev
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

jQuery(document).ready(function($) {
    var mediaUploader;
    $('#change').click(function(e) {
        e.preventDefault();
        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        // Extend the wp.media object
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Your Custom Profile Avatar',
            button: {
                text: 'Choose'
            },
            multiple: false,
            library: {
                type: ['image']
            },
        });
        // When a file is selected, grab the URL and set it as the text field's value
        mediaUploader.on('select', function() {
            attachment = mediaUploader.state().get('selection').first().toJSON();
            $('.user__avatar > .avatar').attr('src', attachment.url);
            $('input[name="avatar__val"]').attr('value', attachment.url);
            if (!$('.user__avatar').children().hasClass('remove')) { $('.user__avatar > .avatar').after('<div class="remove"></div>') };
        });
        // Open the uploader dialog
        mediaUploader.open();
    });
    $(document).on('click', '.remove', function() {
        var pull = $('#pull > img').attr('src');
        $('.user__avatar .avatar').attr('src', pull);
        $('input[name="avatar__val"]').removeAttr('value');
        $(this).remove();
    });
});