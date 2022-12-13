<?php

function menuPersmission(string $menu, string $action): bool
{
    $session = \Config\Services::session();

    $name_role = $session->get('role');
    if ($name_role == '1') {
        $arr = [
            'user' => ['read' => false, 'create' => false, 'update' => false, 'delete' => false, 'detail' => false],
            'worker' => ['read' => false, 'create' => false, 'update' => false, 'delete' => false, 'detail' => false],
            'bonuses' => ['read' => true, 'create' => true, 'update' => false, 'delete' => false, 'detail' => true],

        ];
    } else if ($name_role == '2') {
        $arr = [
            'user' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true, 'detail' => true],
            'worker' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true, 'detail' => true],
            'bonuses' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true, 'detail' => true],
        ];
    } else {
        $arr = [
            'user' => ['read' => false, 'create' => false, 'update' => false, 'delete' => false, 'detail' => false],
            'worker' => ['read' => false, 'create' => false, 'update' => false, 'delete' => false, 'detail' => false],
            'bonuses' => ['read' => false, 'create' => false, 'update' => false, 'delete' => false, 'detail' => true],

        ];
    }
    if (!$arr[$menu][$action]) {
        session()->setFlashdata('msg', 'Akses Menu di Tolak');
        session()->setFlashdata('bg', 'alert-danger');
        header("location:" . base_url() . "/home");
        exit();
    };
    return true;
}