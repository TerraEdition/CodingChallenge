<?php
function url($type)
{
    switch ($type) {
        case 'cancel':
            $stack = explode('/', current_url());
            array_pop($stack);
            return implode('/', $stack);
        case 'back':
            return $_SESSION['_ci_previous_url'];
        default:
            break;
    }
}

function uri($no)
{
    $request = \Config\Services::request();
    if ($request->uri->getTotalSegments() >= $no) {
        return  $request->uri->getSegment($no);
    }
    return false;
}