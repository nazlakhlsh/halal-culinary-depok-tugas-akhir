<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Admin Controller untuk Dashboard Admin
 * Sistem Informasi Spasial Sebaran Outlet Kuliner Halal
 *
 * @property CI_Session $session
 * @property CI_Input $input
 * @property Kuliner_model $kuliner
 * @property User_model $user
 */
class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load libraries, models, dan helpers
        $this->load->library('session');
        $this->load->model('Kuliner_model', 'kuliner');
        $this->load->model('User_model', 'user');

        // Load helpers satu per satu untuk kompatibilitas
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->helper('date');

        // Keamanan: Wajib login
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('auth/login');
        }

        // Keamanan: Wajib role 'admin'
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Hanya admin yang dapat mengakses halaman ini.');
            redirect('/');
        }
    }

    /**
     * Halaman utama dashboard admin
     * Menampilkan daftar kuliner yang butuh verifikasi dan statistik
     */
    public function index()
    {
        $data = array(
            'title' => 'Dashboard Admin',
            // REVISI: Menggunakan 'logged_in_user' agar konsisten
            'logged_in_user' => $this->user->get_user_by_id($this->session->userdata('id')),
            'pending_kuliner' => $this->kuliner->get_kuliner_by_status('pending', true),
            'statistics' => array(
                'total_kuliner' => $this->kuliner->count_kuliner_by_status(),
                'verified_kuliner' => $this->kuliner->count_kuliner_by_status('verified'),
                'pending_kuliner' => $this->kuliner->count_kuliner_by_status('pending'),
                'rejected_kuliner' => $this->kuliner->count_kuliner_by_status('rejected'),
                'total_users' => $this->user->count_all_users()
            )
        );

        $data['active_page'] = 'dashboard';
        $this->load->view('web/admin-dashboard', $data);
    }

    /**
     * Halaman manajemen kuliner
     * Menampilkan semua data kuliner dengan filter status
     */
    public function manajemen_kuliner($status = 'all')
    {
        $data = array(
            'title' => 'Manajemen Data Kuliner',
            // REVISI: Menggunakan 'logged_in_user' agar konsisten
            'logged_in_user' => $this->user->get_user_by_id($this->session->userdata('id')),
            'list_kuliner' => $this->kuliner->get_kuliner_by_status($status, true),
            'current_status' => $status
        );

        // REVISI: Menambahkan active_page
        $data['active_page'] = 'manajemen_kuliner';
        $this->load->view('web/admin-dashboard', $data);
    }

    /**
     * Detail kuliner untuk verifikasi
     */
    public function detail_kuliner($id_kuliner)
    {
        $data_kuliner = $this->kuliner->get_kuliner_by_id($id_kuliner, true);

        if (!$data_kuliner) {
            $this->session->set_flashdata('error', 'Data kuliner tidak ditemukan.');
            // REVISI: Redirect ke halaman manajemen kuliner yang benar
            redirect('admin/manajemen_kuliner');
        }

        $data = array(
            'title' => 'Detail Kuliner: ' . $data_kuliner->nama_kuliner,
            // REVISI: Menggunakan 'logged_in_user' agar konsisten
            'logged_in_user' => $this->user->get_user_by_id($this->session->userdata('id')),
            'kuliner' => $data_kuliner
        );

        // REVISI: Menambahkan active_page
        $data['active_page'] = 'detail_kuliner';
        $this->load->view('web/admin-dashboard', $data);
    }

    /**
     * Fungsi untuk menyetujui (verify) data kuliner
     */
    public function verifikasi($id_kuliner)
    {
        $update_data = array(
            'status_verifikasi' => 'verified'
        );

        $result = $this->kuliner->update_kuliner($id_kuliner, $update_data);

        if ($result) {
            $this->session->set_flashdata('success', 'Data kuliner berhasil diverifikasi.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memverifikasi data kuliner.');
        }

        redirect('admin');
    }

    /**
     * Fungsi untuk menolak (reject) data kuliner
     */
    public function tolak($id_kuliner)
    {
        $update_data = array(
            'status_verifikasi' => 'rejected'
        );

        $result = $this->kuliner->update_kuliner($id_kuliner, $update_data);

        if ($result) {
            $this->session->set_flashdata('success', 'Data kuliner telah ditolak.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menolak data kuliner.');
        }

        redirect('admin');
    }

    /**
     * Fungsi untuk menghapus data kuliner secara permanen
     */
    public function hapus_kuliner($id_kuliner)
    {
        $kuliner = $this->kuliner->get_kuliner_by_id($id_kuliner);

        if (!$kuliner) {
            $this->session->set_flashdata('error', 'Data kuliner tidak ditemukan.');
            redirect('admin/manajemen_kuliner');
        }

        if (!empty($kuliner->foto) && file_exists('./uploads/kuliner/' . $kuliner->foto)) {
            unlink('./uploads/kuliner/' . $kuliner->foto);
        }

        $result = $this->kuliner->delete_kuliner($id_kuliner);

        if ($result) {
            $this->session->set_flashdata('success', 'Data kuliner "' . $kuliner->nama_kuliner . '" berhasil dihapus permanen.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data kuliner.');
        }

        // REVISI: Redirect ke halaman manajemen kuliner yang benar
        redirect('admin/manajemen_kuliner');
    }

    /**
     * Halaman manajemen user
     */
    public function manajemen_users()
    {
        $data = array(
            'title' => 'Manajemen User',
            // REVISI: Menggunakan 'logged_in_user' agar konsisten
            'logged_in_user' => $this->user->get_user_by_id($this->session->userdata('id')),
            'users_list' => $this->user->get_all_users()
        );

        // REVISI: Menambahkan active_page
        $data['active_page'] = 'manajemen_users';
        $this->load->view('web/admin-dashboard', $data);
    }

    /**
     * Fungsi untuk menghapus user
     */
    public function hapus_user($id_user)
    {
        if ($id_user == $this->session->userdata('id')) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            redirect('admin/manajemen_users');
        }

        $result = $this->user->delete_user($id_user);

        if ($result) {
            $this->session->set_flashdata('success', 'User berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user.');
        }

        // REVISI: Redirect ke halaman manajemen user yang benar
        redirect('admin/manajemen_users');
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        $this->session->unset_userdata(array('id', 'nama_lengkap', 'email', 'role', 'is_logged_in'));
        $this->session->set_flashdata('success', 'Anda berhasil logout.');
        redirect('auth/login');
    }
}
