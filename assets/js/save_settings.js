/**
** File: save_settings.js
** Since: 1.3
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
  var oldAvatar = $("#user__avatar > img").attr("src");
  var avatarDisabled = "";

  function showNotice(type, message) {
    if ($("#notf").length > 0) {
      return;
    }

    $(".main__area").after('<div id="notf" class="' + type + '">' + message + "</div>");
    $("#notf")
      .fadeIn(300)
      .css("transform", "translateY(12.5px)")
      .delay(800)
      .fadeOut(600);

    setTimeout(function () {
      $("#notf").remove();
    }, 1800);
  }

  function updateVisibleAvatars(newAvatar, disableState) {
    var oldDefaultAvatar = $("#old__avatar").attr("src");

    $("img").each(function () {
      var $img = $(this);
      var imgId = $img.attr("id");
      var parentId = $img.parent().attr("id");
      var currentSrc = this.currentSrc || $img.attr("src");

      if (imgId === "old__avatar" || parentId === "user__avatar") {
        return;
      }

      if (
        disableState === "" &&
        $img.is("[class*=avatar][class*=photo]") &&
        oldAvatar !== newAvatar
      ) {
        $img.attr("src", newAvatar);
        return;
      }

      var isProfileImg =
        currentSrc === oldAvatar ||
        currentSrc === oldDefaultAvatar ||
        $img.is("[src*='gravatar.com']");

      if (disableState !== "" && isProfileImg) {
        var source =
          disableState === "1"
            ? $("#user__avatar > img").attr("src")
            : oldDefaultAvatar;
        $img.attr("src", source);
      }
    });

    oldAvatar = $("#user__avatar > img").attr("src");
  }

  $(document).on("submit", ".main__area form", function (e) {
    e.preventDefault();

    if ($("#cpa__change__avatar").length > 0) {
      var avatarVal = $("[name='avatar__val']").val();
      $.ajax({
        type: "POST",
        url: cpa__save__settings.ajax_url,
        data: {
          action: "cpa__settings__change__avatar",
          avatar__val: avatarVal,
          security: cpa__save__settings.nonce,
        },
        success: function () {
          var newAvatar = $("#user__avatar > img").attr("src");
          updateVisibleAvatars(newAvatar, avatarDisabled);
          showNotice("scs", "Avatar successfully saved!");
        },
        error: function () {
          showNotice("err", "Avatar not updated!");
        },
      });
    }

    if ($("#cpa__user__permissions").length > 0) {
      var avatarVal = $("[name='avatar__val']").val();
      var disableGravatar = $("[name='disable__gravatar']").is(":checked")
        ? "on"
        : "off";
      var editorPermission = $("[name='editor__permission']").is(":checked")
        ? "on"
        : "off";
      var authorPermission = $("[name='author__permission']").is(":checked")
        ? "on"
        : "off";
      var contributorPermission = $("[name='contributor__permission']").is(
        ":checked"
      )
        ? "on"
        : "off";
      var shopmPermission = $("[name='shopm__permission']").is(":checked")
        ? "on"
        : "off";

      $.ajax({
        type: "POST",
        url: cpa__permission__settings.ajax_url,
        data: {
          action: "cpa__settings__change__permission",
          avatar__val: avatarVal,
          disable__gravatar: disableGravatar,
          editor__permission: editorPermission,
          author__permission: authorPermission,
          contributor__permission: contributorPermission,
          shopm__permission: shopmPermission,
          security: cpa__permission__settings.nonce,
        },
        success: function () {
          avatarDisabled = disableGravatar === "off" ? "0" : "1";
          var newAvatar =
            avatarDisabled === "1"
              ? $("#user__avatar > img").attr("src")
              : $("#old__avatar").attr("src");

          updateVisibleAvatars(newAvatar, avatarDisabled);
          showNotice("scs", "Permissions successfully saved!");
        },
        error: function () {
          showNotice("err", "Permissions not updated!");
        },
      });
    }
  });
});
