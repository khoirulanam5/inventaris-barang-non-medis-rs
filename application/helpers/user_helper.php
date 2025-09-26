<?php

	function isgudang() {
		$ci = get_instance();
		$level = $ci->session->userdata('level');
		if ($level != 'staf gudang') {
			redirect('auth');
		}
	}

	function isunit() {
		$ci = get_instance();
		$level = $ci->session->userdata('level');
		if ($level != 'staf unit') {
			redirect('auth');
		}
	}

	function ispemasok() {
		$ci = get_instance();
		$level = $ci->session->userdata('level');
		if ($level != 'pemasok') {
			redirect('auth');
		}
	}