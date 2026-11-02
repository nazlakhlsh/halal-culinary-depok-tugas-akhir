<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends CI_Controller {

    // TAMBAHKAN FUNGSI CONSTRUCT INI
    public function __construct()
    {
        parent::__construct();
        // Memuat library session agar bisa digunakan di view
        $this->load->library('session');
        // Memuat helper url agar site_url() dan base_url() berfungsi
        $this->load->helper('url');
    }

    public function index()
    {
        // View yang Anda berikan di awal adalah 'web/home'
        $this->load->view('web/home');
    }
}