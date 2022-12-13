<?php
function createBtn($text = "Tambah Data", $bg = 'btn-outline-primary'): string
{
    return '<a href="' . current_url() . '/create" class="btn ' . $bg . '">
    <i class="fa-solid fa-plus"></i>' . $text . '</a>';
}

function editBtn($slug, $text = "Ubah", $bg = "bg-primary"): string
{
    return '<div data-id="' . $slug . '" id="editBtn" class="badge ' . $bg . ' rounded-pill text-decoration-none">
    <i class="fa-solid fa-pen-to-square"></i>' . $text . '
</div>';
}
function deleteBtn($slug, $url, $text = "Hapus", $bg = 'bg-danger'): string
{
    return '<div class="badge ' . $bg . ' rounded-pill text-decoration-none" id="deleteBtn"
    data-id="' . $slug . '" data-url="' . $url . '">
    <i class="fa-solid fa-trash"></i>' . $text . '</div>';
}

function status($bool, $id = false): string
{
    if (filter_var($bool, FILTER_VALIDATE_BOOLEAN)) {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check2-circle"  ' . ($id ? 'id="status" data-id="' . $id . '"' : "") . ' viewBox="0 0 16 16" type="button">
        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
        </svg>';
    } else {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-x-circle"  ' . ($id ? 'id="status" data-id="' . $id . '"' : "") . '  viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
        </svg>';
    }
}

function sortIcon($col): string
{
    if (@$_GET['orderBy'] === $col) {
        $sort = @$_GET['orderSort'];
        if ($sort === 'asc') {
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
            <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
            </svg>';
        } else {
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
            <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zm-8.46-.5a.5.5 0 0 1-1 0V3.707L2.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L4.5 3.707V13.5z"/>
            </svg>';
        }
    } else {
        if ($col === 'id' && !@$_GET['orderBy']) {
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
            <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
            </svg>';
        }
    }
    return "";
}


function sortStat(): string
{
    $sort = @$_GET['orderSort'];
    return ($sort === 'asc') ? 'desc' : 'asc';
}

function showAlert($text, $bg)
{
    return '<div class="alert ' . $bg . ' alert-dismissible fade show" role="alert"> ' . $text . '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>';
}

function box_publish($val = "true")
{
    return
        '<div class="card">
    <div class="card-header font-weight-bold">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tv" viewBox="0 0 16 16">
    <path d="M2.5 13.5A.5.5 0 0 1 3 13h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zM13.991 3l.024.001a1.46 1.46 0 0 1 .538.143.757.757 0 0 1 .302.254c.067.1.145.277.145.602v5.991l-.001.024a1.464 1.464 0 0 1-.143.538.758.758 0 0 1-.254.302c-.1.067-.277.145-.602.145H2.009l-.024-.001a1.464 1.464 0 0 1-.538-.143.758.758 0 0 1-.302-.254C1.078 10.502 1 10.325 1 10V4.009l.001-.024a1.46 1.46 0 0 1 .143-.538.758.758 0 0 1 .254-.302C1.498 3.078 1.675 3 2 3h11.991zM14 2H2C0 2 0 4 0 4v6c0 2 2 2 2 2h12c2 0 2-2 2-2V4c0-2-2-2-2-2z"/>
    </svg>
        Status
    </div>
    <div class="card-body">
        <div class="my-3">
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="publish" id="ya" autocomplete="off" ' . ($val == "true"
            ? "checked" : "") . ' value="true">
                <label class="btn btn-outline-primary" for="ya">Aktif</label>

                <input type="radio" class="btn-check" name="publish" id="tidak" autocomplete="off" ' . ($val == "false"
            ? "checked" : "") . ' value="false">
                <label class="btn btn-outline-danger" for="tidak">Tidak</label>
            </div>
        </div>
    </div>
</div>';
}

function symRequired($no = 1)
{
    $a =  "<span class='text-danger' style='font-size:20px;'> ";
    for ($i = 1; $i <= $no; $i++) {
        $a .= '*';
    }
    $a .= "</span>";
    return $a;
}

function validorno($param)
{
    $validation = \Config\Services::validation();
    if (old($param) != null && $validation->hasError($param) == 1) {
        return 'is-invalid';
    } else if (old($param) == null && $validation->hasError($param) == 1) {
        return 'is-invalid';
    } else  if (old($param) != null && !$validation->hasError($param)) {
        return '';
    } else {
        return '';
    }
}

function saveBtn($text = "Simpan dan Tutup", $bg = "btn-primary")
{
    return '<input type="submit" class="btn ' . $bg . ' my-auto mx-1 fg-primary bg-primary"  name="saveBtn" value="' . $text . '">';
}
function saveCreateBtn($text = "Simpan dan Tambah Baru", $bg = "btn-primary")
{
    return '<input type="submit" class="btn ' . $bg . ' my-auto mx-1" name="savenewBtn" value="' . $text . '">';
}
function cancelBtn($text = 'Batal', $bg = 'danger', $force = false)
{
    $url = url('cancel');
    if (isset($_GET['ref'])) {
        $url = $_GET['ref'];
    } else if (!$force) {
        if (session()->has('_ci_previous_url')) {
            if (session()->get('_ci_previous_url') != current_url()) {
                $url = session()->get('_ci_previous_url');
            }
        }
    }
    return '<a href="' . $url . '" class="btn btn-' . $bg . ' text-light my-auto">' . $text . '</a>';
}