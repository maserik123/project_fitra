<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function btn_import($method, $btn_name)
{ ?>
    <button class="btn btn-xs purple" onclick="<?php $method ?>">
        <i class="fa fa-upload"></i><?php $btn_name ?>
    </button>
<?php } ?>
<?php
function get_btn_group1($btn_edit, $btn_delete)
{
    $li_btn_edit    = '<button class="btn btn-sm blue" title="Edit Data" onClick=' . $btn_edit . '><li class="fa fa-edit"></li></button>';
    $li_btn_delete  = '<button class="btn btn-sm red" title="Hapus Data" onClick=' . $btn_delete . '><li class="fa fa-trash"></li></button>';
    return '<div class="text-center">' . $li_btn_edit . ' || ' . $li_btn_delete . '</div>';
}

function get_btn_group_delete_disable($btn_edit, $btn_delete)
{
    $li_btn_edit    = '<button class="btn btn-xs blue" title="Edit Data" onClick=' . $btn_edit . '><li class="fa fa-pencil"></li></button>';
    $li_btn_delete  = '<button class="btn btn-xs red" title="Hapus Data" onClick=' . $btn_delete . ' disabled><li class="fa fa-trash"></li></button>';
    return '<div class="text-center">' . $li_btn_edit . $li_btn_delete . '</div>';
}

function get_btn_group($btn_detail, $btn_edit, $btn_delete)
{
    $li_btn_detail  = '<button class="btn btn-xs yellow" title="Lihat Detail" onClick=' . $btn_detail . '><li class="fa fa-search"></li> </button>';
    $li_btn_edit    = '<button class="btn btn-xs blue" title="Edit Data" onClick=' . $btn_edit . '><li class="fa fa-pencil"></li></button>';
    $li_btn_delete  = '<button class="btn btn-xs red" title="Hapus Data" onClick=' . $btn_delete . '><li class="fa fa-trash"></li></button>';
    return '<div class="text-center">' . $li_btn_detail . $li_btn_edit . $li_btn_delete . '</div>';
}

function menubar()
{ }
