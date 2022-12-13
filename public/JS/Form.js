let btnHeader = $(".btnHeader");
let cardHeader = $(".card-header");
let cardFooter = $(".card-footer");
let heightNow = false;
window.addEventListener("scroll", function (e) {
  if (
    window.pageYOffset >= 300 &&
    window.scrollY >= 300 &&
    heightNow == false
  ) {
    heightNow = true;
    cardFooter.append(btnHeader.clone());
  }
});

$("form").submit(function () {
  $(
    ".progress"
  ).html(` <div class="progress-bar progress-bar-striped progress-bar-animated bg-success p-2" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
        <div class="">
        Sedang Proses
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>`);
});
