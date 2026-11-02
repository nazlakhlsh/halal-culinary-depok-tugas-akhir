<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property Kuliner_model $kuliner
 * @property User_model $user
 */
class Umkm extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'url', 'file']);
        $this->load->library(['session', 'form_validation', 'upload']);

        $this->load->model('Kuliner_model', 'kuliner');
        $this->load->model('User_model', 'user');

        // Keamanan: Wajib login
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('auth/login');
        }

        // Keamanan: Wajib role 'umkm'
        if ($this->session->userdata('role') !== 'umkm') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('home');
        }
    }

    // Menampilkan halaman dashboard utama (form tambah)
    public function index()
    {
        // Secara default, arahkan ke form tambah usaha
        $this->tambah_kuliner();
    }

    // Menampilkan daftar kuliner (Outlet Saya)
    public function list_kuliner()
    {
        $id_user = $this->session->userdata('id');
        $data = [
            'title'       => 'Outlet Saya',
            'user'        => $this->user->get_user_by_id($id_user),
            'outlets'     => $this->kuliner->get_kuliner_by_user($id_user), // REVISI: Ganti nama variabel ke 'outlets'
            'active_page' => 'outlet_saya' // REVISI: Tambah penanda halaman
        ];
        $this->load->view('web/umkm-dashboard', $data);
    }

    // REVISI BARU: Method untuk menampilkan detail usaha
    public function detail($id)
    {
        $id_user = $this->session->userdata('id');
        $data_kuliner = $this->kuliner->get_kuliner_by_id_and_user($id, $id_user);

        if (!$data_kuliner) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan atau Anda tidak memiliki akses.');
            redirect('umkm/list_kuliner');
            return;
        }

        $data = [
            'title'       => 'Detail Usaha Kuliner',
            'user'        => $this->user->get_user_by_id($id_user),
            'outlet'      => $data_kuliner, // REVISI: Ganti nama variabel ke 'outlet'
            'active_page' => 'detail_usaha' // REVISI: Tambah penanda halaman
        ];
        $this->load->view('web/umkm-dashboard', $data);
    }

    // Menampilkan form tambah kuliner
    public function tambah_kuliner()
    {
        $data = [
            'title'       => 'Daftarkan Usaha Kuliner',
            'user'        => $this->user->get_user_by_id($this->session->userdata('id')),
            'active_page' => 'daftar_usaha' // REVISI: Tambah penanda halaman
        ];
        $this->load->view('web/umkm-dashboard', $data);
    }

    // Menampilkan form edit
    public function edit_kuliner($id)
    {
        $id_user = $this->session->userdata('id');
        $data_kuliner = $this->kuliner->get_kuliner_by_id_and_user($id, $id_user);

        if (!$data_kuliner) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan atau Anda tidak memiliki akses.');
            redirect('umkm/list_kuliner');
            return;
        }

        $data = [
            'title'       => 'Edit Usaha Kuliner',
            'user'        => $this->user->get_user_by_id($id_user),
            'outlet'      => $data_kuliner, // REVISI: Ganti nama variabel ke 'outlet'
            'active_page' => 'edit_usaha' // REVISI: Tambah penanda halaman
        ];
        $this->load->view('web/umkm-dashboard', $data);
    }

    // Proses menyimpan data kuliner BARU
    public function proses_simpan()
    {
        // Aturan validasi
        $this->form_validation->set_rules('nama_kuliner', 'Nama Kuliner', 'required|trim|is_unique[kuliner.nama_kuliner]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah_kuliner(); // Kembali ke form tambah jika validasi gagal
            return;
        }

        // Proses Upload Foto
        $foto_name = NULL;
        if (!empty($_FILES['foto']['name'])) {
            $config = [
                'upload_path'   => './uploads/kuliner/',
                'allowed_types' => 'jpg|png|jpeg',
                'max_size'      => 2048,
                'encrypt_name'  => TRUE,
            ];
            $this->upload->initialize($config);
            if ($this->upload->do_upload('foto')) {
                $foto_name = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengunggah foto: ' . $this->upload->display_errors());
                redirect('umkm/tambah_kuliner');
                return;
            }
        }

        // Data yang akan disimpan
        $data = [
            'id_user'             => $this->session->userdata('id'),
            'nama_kuliner'        => $this->input->post('nama_kuliner', TRUE),
            'kategori'            => $this->input->post('kategori', TRUE),
            'kecamatan'           => $this->input->post('kecamatan', TRUE),
            'latitude'            => $this->input->post('latitude', TRUE),
            'longitude'           => $this->input->post('longitude', TRUE),
            'alamat'              => $this->input->post('alamat', TRUE),
            'jam_buka'            => $this->input->post('jam_buka', TRUE),
            'sertifikat'          => $this->input->post('sertifikat', TRUE),
            'id_sertifikat'       => $this->input->post('id_sertifikat', TRUE),
            'berlaku_sertifikat'  => $this->input->post('berlaku_sertifikat', TRUE),
            'harga'               => $this->input->post('harga', TRUE),
            'map'                 => $this->input->post('map', TRUE),
            'foto'                => $foto_name,
        ];

        if ($this->kuliner->insert_kuliner($data)) {
            $this->session->set_flashdata('success', 'Usaha kuliner berhasil didaftarkan dan sedang menunggu verifikasi oleh Admin.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data. Silakan coba lagi.');
        }
        redirect('umkm/list_kuliner');
    }

    // Proses mengupdate data kuliner
    public function proses_update()
    {
        $id_kuliner = $this->input->post('id');
        $id_user = $this->session->userdata('id');

        // Validasi kepemilikan
        $kuliner_lama = $this->kuliner->get_kuliner_by_id_and_user($id_kuliner, $id_user);
        if (!$kuliner_lama) {
            $this->session->set_flashdata('error', 'Akses ditolak.');
            redirect('umkm/list_kuliner');
            return;
        }

        // Aturan validasi
        $is_unique = ($this->input->post('nama_kuliner') != $kuliner_lama->nama_kuliner) ? '|is_unique[kuliner.nama_kuliner]' : '';
        $this->form_validation->set_rules('nama_kuliner', 'Nama Kuliner', 'required|trim' . $is_unique);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_kuliner($id_kuliner);
            return;
        }

        // Data yang diupdate
        $data = [
            'nama_kuliner'        => $this->input->post('nama_kuliner', TRUE),
            'kategori'            => $this->input->post('kategori', TRUE),
            'kecamatan'           => $this->input->post('kecamatan', TRUE),
            'latitude'            => $this->input->post('latitude', TRUE),
            'longitude'           => $this->input->post('longitude', TRUE),
            'alamat'              => $this->input->post('alamat', TRUE),
            'jam_buka'            => $this->input->post('jam_buka', TRUE),
            'sertifikat'          => $this->input->post('sertifikat', TRUE),
            'id_sertifikat'       => $this->input->post('id_sertifikat', TRUE),
            'berlaku_sertifikat'  => $this->input->post('berlaku_sertifikat', TRUE),
            'harga'               => $this->input->post('harga', TRUE),
            'map'                 => $this->input->post('map', TRUE),
            'status_verifikasi'   => 'pending'
        ];

        // Proses upload foto baru jika ada
        if (!empty($_FILES['foto']['name'])) {
            $config = [
                'upload_path'   => './uploads/kuliner/',
                'allowed_types' => 'jpg|png|jpeg',
                'max_size'      => 2048,
                'encrypt_name'  => TRUE,
            ];
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto')) {
                // Hapus foto lama
                if ($kuliner_lama->foto && file_exists('./uploads/kuliner/' . $kuliner_lama->foto)) {
                    unlink('./uploads/kuliner/' . $kuliner_lama->foto);
                }
                $data['foto'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengunggah foto baru: ' . $this->upload->display_errors());
                redirect('umkm/edit_kuliner/' . $id_kuliner);
                return;
            }
        }

        if ($this->kuliner->update_kuliner($id_kuliner, $data)) {
            $this->session->set_flashdata('success', 'Data berhasil diperbarui dan akan diverifikasi ulang oleh Admin.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data.');
        }
        redirect('umkm/list_kuliner');
    }

    // Proses menghapus data
    public function hapus_kuliner($id)
    {
        $id_user = $this->session->userdata('id');
        $kuliner = $this->kuliner->get_kuliner_by_id_and_user($id, $id_user);

        if (!$kuliner) {
            $this->session->set_flashdata('error', 'Akses ditolak.');
            redirect('umkm/list_kuliner');
            return;
        }

        // Hapus foto dari server
        if ($kuliner->foto && file_exists('./uploads/kuliner/' . $kuliner->foto)) {
            unlink('./uploads/kuliner/' . $kuliner->foto);
        }

        if ($this->kuliner->delete_kuliner($id)) {
            $this->session->set_flashdata('success', 'Data usaha kuliner berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }
        redirect('umkm/list_kuliner');
    }
}
