//javascript.js

document.getElementById("open_btn").addEventListener("click", function () {
  document.getElementById("sidebar").classList.toggle("open-sidebar");
});

$(document).ready(function () {
  $(".dropdown-toggle").on("click", function (e) {
    var $dropdownMenu = $(this).next(".dropdown-menu");

    if (!$dropdownMenu.hasClass("show")) {
      $(".dropdown-menu.show").removeClass("show");
    }

    $dropdownMenu.toggleClass("show");
    e.stopPropagation();
  });

  $(document).on("click", function (e) {
    if (!$(e.target).closest(".dropdown").length) {
      $(".dropdown-menu.show").removeClass("show");
    }
  });
});
