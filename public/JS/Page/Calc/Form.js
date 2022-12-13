function delay(fn, ms) {
  let timer = 0;
  return function (...args) {
    clearTimeout(timer);
    timer = setTimeout(fn.bind(this, ...args), ms || 0);
  };
}

function removeWorker() {
  $("*")
    .find("#removeWorker")
    .each(function () {
      $(this).click(() => {
        $(this).parent().parent().remove();
        calc();
      });
    });
}
function detectPercent() {
  $("*")
    .find("#persen")
    .each(function () {
      $(this).keyup(() => {
        if (parseInt($(this).val()) < 0) {
          $(this).val(0);
        } else if (parseInt($(this).val()) > 100) {
          $(this).val(100);
        }
        calc();
      });
    });
}
const formatter = new Intl.NumberFormat("id-ID", {
  style: "currency",
  currency: "IDR",
});

function calc() {
  if ($("#pembayaran").val() != "") {
    sum = 0;
    $("*")
      .find("#persen")
      .each(function () {
        val = $(this).val() == "" ? 0 : parseInt($(this).val());
        res = formatter.format((parseInt($("#pembayaran").val()) * val) / 100);

        sum = sum + val;
        $(this).parent().parent().children().eq(2).text(res);
      });

    if (sum < 100 || sum > 100) {
      $("#notifSum").text("Pembagian Bonus Masih Salah : " + sum + " %");
    } else {
      $("#notifSum").text("");
    }
  }
}

function addFormWorker(n = 1) {
  console.log(n);
  const form = `
  <td>
  <input type="text" class="form-control" name="nama[]" list="namalist999" id="nama">
  <datalist id="namalist999">
  </datalist>
  </td>
  <td><input type="number" class="form-control" name="persen[]" id="persen" min='0' max='100'/></td>
  <td></td>
  <td><button class="btn btn-outline-danger" type="button" id="removeWorker"><i class="fa-solid fa-trash"></i></button></td>`;

  for (let i = 0; i < n; i++) {
    $("#listWorker").append($("<tr></tr>").html(form));
  }

  removeWorker();
  detectPercent();
}

function getWorker() {
  n = "";
  $("*")
    .find("#nama")
    .each(function () {
      if (!$(this).is(":focus")) {
        n += $(this).val() + ",";
      }
    });

  return $.get(
    _BASE_URL + "/worker/except?worker=" + n,
    function (d) {},
    "json"
  );
}
$("#addWorker").click(function () {
  const n = $("#s").val() == "" ? 1 : $("#s").val();
  addFormWorker(n);
  search();
});

$("#pembayaran").keyup(calc);

function search() {
  $("*")
    .find("#nama")
    .each(function () {
      $(this).keyup(
        delay(async function () {
          if ($(this).val() != "") {
            const data = await getWorker();
            el = ``;
            data.forEach((r) => {
              el += `<option value="${r.name}"></option>`;
            });
            $(this).parent().children().eq(1).html(el);
          }
        }, "500")
      );
    });
}

removeWorker();
detectPercent();
calc();
search();
