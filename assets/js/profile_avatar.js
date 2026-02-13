/**
** File: profile_avatar.js
** Since: 1.4
** Author: en0ndev
*/

jQuery(function ($) {
  function setAvatar($wrap, src) {
    $wrap.find(".cpa-profile-avatar-image").attr("src", src);
  }

  $(document).on("click", ".cpa-profile-avatar-change", function (e) {
    e.preventDefault();

    const $wrap = $(this).closest(".cpa-profile-avatar-wrap");
    const $input = $("#cpa_profile_avatar");
    const $remove = $wrap.find(".cpa-profile-avatar-remove");

    const mediaFrame = wp.media({
      title: "Choose Avatar",
      button: { text: "Use this image" },
      multiple: false,
      library: { type: ["image"] },
    });

    mediaFrame.on("select", function () {
      const attachment = mediaFrame.state().get("selection").first().toJSON();
      setAvatar($wrap, attachment.url);
      $input.val(attachment.url);
      $remove.removeClass("hidden");
    });

    mediaFrame.open();
  });

  $(document).on("click", ".cpa-profile-avatar-remove", function (e) {
    e.preventDefault();

    const $wrap = $(this).closest(".cpa-profile-avatar-wrap");
    const fallback = $wrap.data("fallback");

    setAvatar($wrap, fallback);
    $("#cpa_profile_avatar").val("");
    $(this).addClass("hidden");
  });
});
