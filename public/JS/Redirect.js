function editUrl(url, id) {
  window.location.replace(url + "/" + id);
}
function printUrl(url, id) {
  window.location.replace(url + "/" + id);
}

function confirmation(ask, url, id) {
  const modal = `
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">${ask}</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-5">
                            <button type="button" class="btn btn-danger text-light my-2" onclick="deleteUrl('${url}','${id}','true')" > Hapus Permanen</button >
                        </div>
                        <div class="col-7 offset-5 text-end">
                            <button type="button" class="btn btn-primary my-2" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div >
            </div >
        </div >
    </div >
        `;
  $("#mainDeleteModal").html(modal);
  new bootstrap.Modal($("#confirmModal"), {
    keyboard: true,
    backdrop: "static",
  }).show();
}

function deleteUrl(url, slug) {
  const token = $("#terra_token");
  const form = `
        <form action="${url}" id="form-delete" method="POST">
            <input type="hidden" name="slug" value="${slug}">
            <input type="hidden" name="ref" value="${url}">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="${token.data(
              "token"
            )}" value="${token.val()}">
    </form >
        `;
  $("#mainDeleteModal").html(form);
  $("#form-delete").submit();
}

function changeStatus(id) {
  window.location.replace(
    _CURRENT_URL + "/status/" + id + "?ref=" + _CURRENT_URL
  );
}

$("*")
  .find("#editBtn")
  .each(function () {
    $(this).click(() => {
      editUrl(_CURRENT_URL, $(this).data("id"));
    });
  });

$("*")
  .find("#deleteBtn")
  .each(function () {
    $(this).click(() => {
      confirmation("Konfirmasi ?", _CURRENT_URL, $(this).data("id"));
    });
  });
$("*")
  .find("#status")
  .each(function () {
    $(this).click(() => {
      changeStatus($(this).data("id"));
    });
  });

$("th#sort").each(function () {
  $(this).click(() => {
    $("input[name*=orderBy]").val($(this).data("col"));
    $("input[name*=orderSort]").val($(this).data("sort"));
    $(this).attr("data-sort", $(this).data("sort") === "asc" ? "desc" : "asc");
    $("input[type=submit][value=Cari]").click();
  });
});
