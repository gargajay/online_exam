/**
 * Global admin functions
 */

(function ($) {
  "use strict";

  /**
   * Enable tooltips
   */
  if ($(".tooltips").length) {
    $(".tooltips").tooltip();
  }

  /**
   * Activate any date pickers
   */

  if ($(".input-group.date").length) {
    $(".input-group.date").datepicker({
      autoclose: true,
      todayHighlight: true,
    });
  }

  /**
   * Detect items per page change on all list pages and send users back to page 1 of the list
   */
  $("select#limit").change(function () {
    var limit = $(this).val();
    var currentUrl = document.URL.split("?");
    var uriParams = "";
    var separator;

    if (currentUrl[1] != undefined) {
      var parts = currentUrl[1].split("&");

      for (var i = 0; i < parts.length; i++) {
        if (i == 0) {
          separator = "?";
        } else {
          separator = "&";
        }

        var param = parts[i].split("=");

        if (param[0] == "limit") {
          uriParams += separator + param[0] + "=" + limit;
        } else if (param[0] == "offset") {
          uriParams += separator + param[0] + "=0";
        } else {
          uriParams += separator + param[0] + "=" + param[1];
        }
      }
    } else {
      uriParams = "?limit=" + limit;
    }

    // reload page
    window.location.href = currentUrl[0] + uriParams;
  });

  /**
   * Enable Summernote WYSIWYG editor on any textareas with the 'editor' class
   */
  if ($("textarea.editor").length) {
    $("textarea.editor").each(function () {
      var id = $(this).attr("id");
      $("#" + id).summernote({
        height: 300,
        width: '100%',
        callbacks: {
                    //onImageUpload: function (image) 
                    onImageUpload: function (image) {

                        uploadImage(image[0]);
                    }
                },
      });
    });
  }

  function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            data.append(csrf_Name,csrf_Hash);

            $.ajax({
                url: BASE_URL+"admin/QuizController/summernoteimg",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "post",
                success: function (url) 
                {
                  url = JSON.parse(url);
                    if (url.status == 1) {
                        var image = $('<img>').attr('src',url.path);
                        $("textarea.editor").summernote("insertNode", image[0]);
                    }
                    else
                    {
                      console.log(url.message);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

  /**
   * Configurations
   */
  var config = {
    logging: true,
    baseURL: BASE_URL,
  };

  /**
   * Bootstrap IE10 viewport bug workaround
   */
  if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement("style");
    msViewportStyle.appendChild(
      document.createTextNode("@-ms-viewport{width:auto!important}")
    );
    document.querySelector("head").appendChild(msViewportStyle);
  }

  /**
   * Execute an AJAX call
   */
  function executeAjax(url, data, callback) {
    $.ajax({
      type: "POST",
      url: url,
      data: data,
      dataType: "json",
      async: true,
      success: function (results) {
        callback(results);
      },
      error: function (error) {
        alert("Error " + error.status + ": " + error.statusText);
      },
    });
    // prevent default action
    return false;
  }

  /**
   * Global core functions
   */
  $(document).ready(function () {
    /**
     * Session language selected
     */
    $("#session-language-dropdown a").on("click", function (e) {
      // prevent default behavior
      if (e.preventDefault) {
        e.preventDefault();
      } else {
        e.returnValue = false;
      }

      // set up post data
      var postData = {
        language: $(this).attr("rel"),
      };

      // define callback function to handle AJAX call result
      var ajaxResults = function (results) {
        if (results.success) {
          location.reload();
        } else {
          alert("{{core error session_language}}");
        }
      };

      // perform AJAX call
      executeAjax(
        config.baseURL + "ajax/set_session_language",
        postData,
        ajaxResults
      );
    });
  });
})(jQuery);
