(function ($) {
  "use strict";

  $(document).ready(function () {
    var itemsMainDiv = ".MultiCarousel";
    var itemsDiv = ".MultiCarousel-inner";
    var itemWidth = "";

    $(".leftLst, .rightLst").on('click', function () {
      var condition = $(this).hasClass("leftLst");
      if (condition) click(0, this);
      else click(1, this);
    });

    ResCarouselSize();

    $(window).resize(function () {
      ResCarouselSize();
    });

    //this function define the size of the items
    function ResCarouselSize() {
      var incno = 0;
      var dataItems = "data-items";
      var itemClass = ".item";
      var id = 0;
      var btnParentSb = "";
      var itemsSplit = "";
      var sampwidth = $(itemsMainDiv).width();
      var bodyWidth = $("body").width();
      $(itemsDiv).each(function () {
        id = id + 1;
        var itemNumbers = $(this).find(itemClass).length;
        btnParentSb = $(this).parent().attr(dataItems);
        itemsSplit = btnParentSb.split(",");
        $(this)
          .parent()
          .attr("id", "MultiCarousel" + id);

        if (bodyWidth >= 1200) {
          incno = itemsSplit[3];
          itemWidth = sampwidth / incno;
        } else if (bodyWidth >= 992) {
          incno = itemsSplit[2];
          itemWidth = sampwidth / incno;
        } else if (bodyWidth >= 768) {
          incno = itemsSplit[1];
          itemWidth = sampwidth / incno;
        } else {
          incno = itemsSplit[0];
          itemWidth = sampwidth / incno;
        }
        $(this).css({
          transform: "translateX(0px)",
          width: itemWidth * itemNumbers,
        });
        $(this)
          .find(itemClass)
          .each(function () {
            $(this).outerWidth(itemWidth);
          });

        $(".leftLst").addClass("over");
        $(".rightLst").removeClass("over");
      });
    }

    //this function used to move the items
    function ResCarousel(e, el, s) {
      var leftBtn = ".leftLst";
      var rightBtn = ".rightLst";
      var translateXval = "";
      var divStyle = $(el + " " + itemsDiv).css("transform");
      var values = divStyle.match(/-?[\d\.]+/g);
      var xds = Math.abs(values[4]);
      if (e == 0) {
        translateXval = parseInt(xds) - parseInt(itemWidth * s);
        $(el + " " + rightBtn).removeClass("over");

        if (translateXval <= itemWidth / 2) {
          translateXval = 0;
          $(el + " " + leftBtn).addClass("over");
        }
      } else if (e == 1) {
        var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
        translateXval = parseInt(xds) + parseInt(itemWidth * s);
        $(el + " " + leftBtn).removeClass("over");

        if (translateXval >= itemsCondition - itemWidth / 2) {
          translateXval = itemsCondition;
          $(el + " " + rightBtn).addClass("over");
        }
      }
      $(el + " " + itemsDiv).css(
        "transform",
        "translateX(" + -translateXval + "px)"
      );
    }

    //It is used to get some elements from btn
    function click(ell, ee) {
      var Parent = "#" + $(ee).parent().attr("id");
      var slide = $(Parent).attr("data-slide");
      ResCarousel(ell, Parent, slide);
    }
  });

  $(document).ready(function () {
    $(".select2").select2();

  });

  function check_rtl_slick(){
    if (rtl_dir) {
       return true;
    } else {
       return false;
    }
  }
  //Slick Carousel Controllers
  $(".testimonial-reel").slick({

    centerMode: true,
    centerPadding: "40px",
    dots: false,
    slidesToShow: 1,
    infinite: true,
    arrows: true,
    rtl:check_rtl_slick(),
    lazyLoad: "ondemand",
    prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/images/arrow-left.png'>",
    nextArrow: "<img class='a-right control-c next slick-next' src='assets/images/arrow-right.png'>",
    responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          centerMode: false,
        },
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });

  $(".no_quiz_start").on("click", function (e) { 
    var link = $(this).attr("href");

    if (login_user_id == 0 && ad_active_quiz == "") {
      e.preventDefault();
      swal({
          title: "Enter Your Name",
          type: "input",
          showCancelButton: true,
          closeOnConfirm: false,
          inputPlaceholder: "Write Your Name Here",
          confirm: {
            text: "Proceed",
          },
        },
        function (inputValue) {
          if (inputValue === false) return false;
          if (inputValue === "") {
            swal.showInputError("Plz Enter Name First!");
            return false;
          } else {
            var base_url = $("#main_base_url").val();

            $.ajax({
              type: "POST",
              url: BASE_URL + "quiz_Controller/set_leader_bord_user_name",
              data: {
                inputValue: inputValue,
              },

              success: function (response) {
                if (response) {
                  response = JSON.parse(response);
                  if (response.status != "error") {
                    window.location.href = link;
                  } else {
                    swal(response.msg, "error");
                    location.reload();
                  }
                } else {
                  swal("Server Response Error", "error");
                }
              },
              error: function (e) {
                console.log(e);
              },
            });
          }
        }
      );
    } else {
      location.reload();
    }
  });

  $(".quiz_running").on("click", function (e) {
    var link = $(this).attr("href");

    e.preventDefault(false);

    swal({
        title: quiz_already_running,
        text: stop_running_quiz_msg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: resume_quiz,
        cancelButtonText: stop_quiz,
      },
      function (isConfirm) {
        if (isConfirm == true) {
          window.location.href = link;
        } else {
          var session_quiz_id = $(".session_quiz_id").val();
          window.location.href = BASE_URL + "result/" + session_quiz_id;
        }
      }
    );
  });

  $(".sponsers").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    rtl:check_rtl_slick(),
  });

  $(".timerrr")
    .startTimer({
      onComplete: function (element) {
        $("#myform").html("");
        $("html, body").addClass("bodyTimeoutBackground");
        location.reload();
      },
    })
    .click(function () {
      location.reload();
    });


})(jQuery);