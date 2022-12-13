<?php
function year_month($date): string
{
    if (!str_contains($date, '-')) {
        $date = timestamp_to_date($date);
    }
    $pecah = explode('-', $date);
    $bulan = $pecah[1];
    $tahun = $pecah[0];
    return $tahun . '-' . $bulan;
}
function timestamp_to_datetime($date): string
{
    return date('Y-m-d H:i:s', $date);
}
function timestamp_to_date($date): string
{
    return $date ? date('Y-m-d', $date) : true;
}
if (!function_exists('tgl_indo')) {
    function date_indo($date = false, $time = false, $showTime = false): string
    {
        if (!$date) {
            return false;
        }

        if (!str_contains($date, '-')) {
            $date = timestamp_to_datetime(($date));
        }
        if ($time == true) {
            $tgl = explode(' ', $date)[0];
        } else {
            $tgl = $date;
        }
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        if ($time == true && $showTime == true) {
            return $tanggal . ' ' . $bulan . ' ' . $tahun . ' / ' . explode(' ', $date)[1];
        } else {
            return $tanggal . ' ' . $bulan . ' ' . $tahun;
        }
    }
}

if (!function_exists('bulan')) {
    function bulan($bln, $angka = false): string
    {
        if ($angka == false) {
            switch ($bln) {
                case 1:
                    return "Januari";
                case 2:
                    return "Februari";
                case 3:
                    return "Maret";

                case 4:
                    return "April";

                case 5:
                    return "Mei";

                case 6:
                    return "Juni";

                case 7:
                    return "Juli";

                case 8:
                    return "Agustus";

                case 9:
                    return "September";

                case 10:
                    return "Oktober";

                case 11:
                    return "November";

                case 12:
                    return "Desember";
            }
        } else {
            switch ($bln) {
                case "Januari":
                    return '01';

                case "Februari":
                    return '02';

                case "Maret":
                    return '03';

                case "April":
                    return '04';

                case "Mei":
                    return '05';

                case "Juni":
                    return '06';

                case "Juli":
                    return '07';

                case "Agustus":
                    return '08';

                case "September":
                    return '09';

                case "Oktober":
                    return '10';

                case "November":
                    return '11';

                case "Desember":
                    return '12';
            }
        }
    }
}

//Format Shortdate
if (!function_exists('shortdate_indo')) {
    function shortdate_indo($tgl): string
    {
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = short_bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . '/' . $bulan . '/' . $tahun;
    }
}

if (!function_exists('short_bulan')) {
    function short_bulan($bln): string
    {
        switch ($bln) {
            case 1:
                return "01";

            case 2:
                return "02";

            case 3:
                return "03";

            case 4:
                return "04";

            case 5:
                return "05";

            case 6:
                return "06";

            case 7:
                return "07";

            case 8:
                return "08";

            case 9:
                return "09";

            case 10:
                return "10";

            case 11:
                return "11";

            case 12:
                return "12";
        }
    }
}

//Format Medium date
if (!function_exists('mediumdate_indo')) {
    function mediumdate_indo($tgl): string
    {
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = medium_bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . '-' . $bulan . '-' . $tahun;
    }
}

if (!function_exists('medium_bulan')) {
    function medium_bulan($bln): string
    {
        switch ($bln) {
            case 1:
                return "Jan";

            case 2:
                return "Feb";

            case 3:
                return "Mar";

            case 4:
                return "Apr";

            case 5:
                return "Mei";

            case 6:
                return "Jun";

            case 7:
                return "Jul";

            case 8:
                return "Ags";

            case 9:
                return "Sep";

            case 10:
                return "Okt";

            case 11:
                return "Nov";

            case 12:
                return "Des";
        }
    }
}

//Long date indo Format
if (!function_exists('longdate_indo')) {
    function longdate_indo($tanggal): string
    {
        $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tgl = $pecah[2];
        $bln = $pecah[1];
        $thn = $pecah[0];
        $bulan = bulan($pecah[1]);
        $nama_hari = nama_hari($bln, $tgl, $thn);
        return $nama_hari . ',' . $tgl . ' ' . $bulan . ' ' . $thn;
    }
}
if (!function_exists('nama_hari')) {
    function nama_hari($bln, $tgl, $thn): string
    {
        $nama = date("l", mktime(0, 0, 0, $bln, $tgl, $thn));
        $nama_hari = "";
        if ($nama == "Sunday") {
            $nama_hari = "Minggu";
        } else if ($nama == "Monday") {
            $nama_hari = "Senin";
        } else if ($nama == "Tuesday") {
            $nama_hari = "Selasa";
        } else if ($nama == "Wednesday") {
            $nama_hari = "Rabu";
        } else if ($nama == "Thursday") {
            $nama_hari = "Kamis";
        } else if ($nama == "Friday") {
            $nama_hari = "Jumat";
        } else if ($nama == "Saturday") {
            $nama_hari = "Sabtu";
        }
        return $nama_hari;
    }
}