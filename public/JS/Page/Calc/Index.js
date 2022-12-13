function showModal() {
  new bootstrap.Modal($("#detailModal"), {
    keyboard: true,
    backdrop: "static",
  }).show();
}

const formatter = new Intl.NumberFormat("id-ID", {
  style: "currency",
  currency: "IDR",
});

$("*")
  .find("#detailBtn")
  .each(function () {
    $(this).click(function () {
      $.get(
        _BASE_URL + "/calc/detail/" + $(this).data("slug"),
        function (d) {
          let form;
          let del;
          $("#titleBonuses").html(`
            <tr>
              <th colspan='2' class='text-center'>Total</th>
              <th>${formatter.format(d.total)}</th>
            </tr>`);
          $.each(d.data, function (k, v) {
            form += `
              <tr>
                <td>${v.name}</td>
                <td>${v.percent} %</td>
                <td>${formatter.format(v.result)}</td>
              </tr>`;
          });
          $("#generateData").html(form);
          if (d.delete) {
            del = `
            <button type="button" class="btn btn-danger" id="deleteBtn" data-id="${d.data[0].slug}" data-url="${_CURRENT_URL}">Hapus</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>`;
          } else {
            del = `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>`;
          }
          $(".modal-footer").html(del);
          $("#deleteBtn").click(function () {
            deleteUrl(_CURRENT_URL, $(this).data("id"));
          });
        },
        "json"
      );
      showModal();
    });
  });

$("#s").on("keyup", function () {
  let value = $(this).val().toLowerCase();
  $("#detailTable tbody tr").filter(function () {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
  });
});
