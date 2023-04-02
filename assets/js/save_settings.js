/**
** File: save_settings.js
** Version: 1.3
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
  var cpa__get__oldavatar = $("#user__avatar > img").attr("src");
  var avatar__disabled = "";

  function getImgAfterUpdate(cpa__get__newavatar, avatar__disabled) {
    for (let getInd = 0; getInd < $("img").length; getInd++) {
      if (avatar__disabled == "" && $("img:eq("+getInd+")[class*=avatar][class*=photo]").length > 0 && cpa__get__oldavatar != cpa__get__newavatar && $("img")[getInd]["id"] != "old__avatar") {
        //console.log("1-1: "+$("img")[getInd]["currentSrc"]);
        $("img:eq("+getInd+")").attr("src", cpa__get__newavatar);
        //console.log("1-2: "+$("img")[getInd]["currentSrc"]);
      }
      else if (avatar__disabled != "" && ($("img")[getInd]["currentSrc"] == cpa__get__oldavatar || $("img")[getInd]["currentSrc"] == $("#old__avatar").attr("src") || $("img:eq("+getInd+")[src*='gravatar.com']").length > 0) && $("img")[getInd]["id"] != "old__avatar" && $("img:eq("+getInd+")").parent().attr("id") != "user__avatar") {
        //console.log("2-1: "+$("img")[getInd]["currentSrc"]);
        avatar__disabled == "1" ? $("img:eq("+getInd+")").attr("src", $("#user__avatar > img").attr("src")) : $("img:eq("+getInd+")").attr("src", $("#old__avatar").attr("src"));
        //console.log("2-2: "+$("img")[getInd]["currentSrc"]);
      }
    }
    //console.log("Old Avatar: "+cpa__get__oldavatar);
    //console.log("New Avatar: "+cpa__get__newavatar);
    cpa__get__oldavatar = $("#user__avatar > img").attr("src");
  }

  $(document).submit("[name='cpa__save__avatar']", function (e) {
    e.preventDefault();

    //var cpa__get__newavatar = $("#user__avatar > img").attr("src");

    if ($("#cpa__change__avatar").length > 0) {
      var avatar__val = $("[name='avatar__val']").val();
      $.ajax({
        type: "POST",
        url: cpa__save__settings.ajax_url,
        data: {
          action: "cpa__settings__change__avatar",
          avatar__val: avatar__val,
        },
        success: function () {
          //alert("Success");
          var cpa__get__newavatar = $("#user__avatar > img").attr("src");
          getImgAfterUpdate(cpa__get__newavatar, avatar__disabled);
          if ($("#notf").length < 1) {
            $(".main__area").after("<div id='notf' class='scs'>Avatar successfully saved!</div>");
            $("#notf").fadeIn(300).css("transform","translateY(12.5px)").delay(800).fadeOut(600);
            setTimeout(function() {
              $("#notf").remove();
            },1800);
          }
        },
        error: function () {
          //alert("Error");
          if ($("#notf").length < 1) {
            $(".main__area").after("<div id='notf' class='err'>Avatar not updated!</div>");
            $("#notf").fadeIn(300).css("transform","translateY(12.5px)").delay(800).fadeOut(600);
            setTimeout(function() {
              $("#notf").remove();
            },1800);
          }
        },
      });

    }

    //

    if ($("#cpa__user__permissions").length > 0) {
      var avatar__val = $("[name='avatar__val']").val();
      var disable__gravatar = $("[name='disable__gravatar']").is(":checked") ? "on" : "off";
      var editor__permission = $("[name='editor__permission']").is(":checked") ? "on" : "off";
      var author__permission = $("[name='author__permission']").is(":checked") ? "on" : "off";
      var contributor__permission = $("[name='contributor__permission']").is(":checked") ? "on" : "off";
      var shopm__permission = $("[name='shopm__permission']").is(":checked") ? "on" : "off";
      $.ajax({
        type: "POST",
        url: cpa__permission__settings.ajax_url,
        data: {
          action: "cpa__settings__change__permission",
          avatar__val: avatar__val,
          disable__gravatar: disable__gravatar,
          editor__permission: editor__permission,
          author__permission: author__permission,
          contributor__permission: contributor__permission,
          shopm__permission: shopm__permission,
        },
        success: function (response) {
          //alert("Success");
          disable__gravatar == "off" ? avatar__disabled = "0" : avatar__disabled = "1";
          var cpa__get__newavatar = avatar__disabled == "1" ? $("#user__avatar > img").attr("src") : $("#old__avatar").attr("src");
          getImgAfterUpdate(cpa__get__newavatar, avatar__disabled);
          if ($("#notf").length < 1) {
            $(".main__area").after("<div id='notf' class='scs'>Permissions successfully saved!</div>");
            $("#notf").fadeIn(300).css("transform","translateY(12.5px)").delay(800).fadeOut(600);
            setTimeout(function() {
              $("#notf").remove();
            },1800);
          }
          //console.log(response);
        },
        error: function () {
          //alert("Error");
          if ($("#notf").length < 1) {
            $(".main__area").after("<div id='notf' class='err'>Permissions not updated!</div>");
            $("#notf").fadeIn(300).css("transform","translateY(12.5px)").delay(800).fadeOut(600);
            setTimeout(function() {
              $("#notf").remove();
            },1800);
          }
        },
      });

    }

    //

  });
});
