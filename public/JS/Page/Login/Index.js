$("#togglePass").click(() => {
  $("#togglePass").toggleClass("hide");
  if ($("#togglePass").hasClass("hide")) {
    $("#password").attr("type", "text");
    $("#togglePass").html(` <i class="fa-solid fa-eye"></i>`);
  } else {
    $("#password").attr("type", "password");
    $("#togglePass").html(`<i class="fa-solid fa-eye-slash"></i>`);
  }
});
