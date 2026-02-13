/**
** File: modules.js
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

jQuery(document).ready(function ($) {
  var mediaUploader = null;

  $(document).on("click", "#change", function (e) {
    e.preventDefault();

    if (mediaUploader) {
      mediaUploader.open();
      return;
    }

    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: "Choose Your Custom Profile Avatar",
      button: {
        text: "Choose",
      },
      multiple: false,
      library: {
        type: ["image"],
      },
    });

    mediaUploader.on("select", function () {
      const attachment = mediaUploader.state().get("selection").first().toJSON();
      const $avatar = $(".user__avatar > .avatar");
      const $avatarInput = $('input[name="avatar__val"]');

      $avatar.attr("src", attachment.url);
      $avatarInput.val(attachment.url);

      if ($(".user__avatar > .remove").length < 1) {
        $(".user__avatar > .avatar").after('<div class="remove"></div>');
      }
    });

    mediaUploader.open();
  });

  $(document).on("click", ".remove", function () {
    var pull = $("#pull > img").attr("src");
    $(".user__avatar .avatar").attr("src", pull);
    $('input[name="avatar__val"]').val("");
    $(this).remove();
  });

  $(document).on("click", "[name='disable__gravatar']", function () {
    if ($(this).is(":checked")) {
      $(".collapse__disable__avatar").stop(true, true).fadeIn(250);
      return;
    }

    $(".collapse__disable__avatar").stop(true, true).fadeOut(250);
  });
});
