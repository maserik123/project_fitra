<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

	function userLog($aksi='',$ket=''){
		$CI = get_instance();
		$log=array(
				'jenis_aksi'  =>$aksi,
				'keterangan'  =>$ket,
				'tgl'         =>date('Y-m-d H:i:s'),
				'pengguna_id' =>$CI->session->userdata('pengguna_id'),
				'status'      =>1,
				'ip_addr'     =>$_SERVER['REMOTE_ADDR']
				);
		return $log;
	}




?>