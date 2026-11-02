<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kuliner_model extends CI_Model
{
    protected $table = 'kuliner';
    protected $users_table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI-FUNGSI UNTUK ADMIN
    |--------------------------------------------------------------------------
    */

    /**
     * Mengambil data kuliner berdasarkan ID. Bisa join dengan data user.
     * @param int $id_kuliner
     * @param bool $join_user
     * @return object|null
     */
    public function get_kuliner_by_id($id_kuliner, $join_user = false)
    {
        if ($join_user) {
            $this->db->select("{$this->table}.*, {$this->users_table}.nama_lengkap as nama_pemilik");
            $this->db->join($this->users_table, "{$this->users_table}.id = {$this->table}.id_user", 'left');
        }
        return $this->db->get_where($this->table, ["{$this->table}.id" => $id_kuliner])->row();
    }

    /**
     * Mengambil data kuliner berdasarkan status verifikasi.
     * @param string $status ('all', 'pending', 'verified', 'rejected')
     * @param bool $join_user
     * @return array
     */
    public function get_kuliner_by_status($status = 'all', $join_user = false)
    {
        if ($join_user) {
            $this->db->select("{$this->table}.*, {$this->users_table}.nama_lengkap as nama_pemilik");
            $this->db->join($this->users_table, "{$this->users_table}.id = {$this->table}.id_user", 'left');
        }

        if ($status !== 'all' && in_array($status, ['pending', 'verified', 'rejected'])) {
            $this->db->where('status_verifikasi', $status);
        }

        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Menghitung jumlah data kuliner berdasarkan status.
     * @param string|null $status
     * @return int
     */
    public function count_kuliner_by_status($status = null)
    {
        if ($status !== null && in_array($status, ['pending', 'verified', 'rejected'])) {
            $this->db->where('status_verifikasi', $status);
        }
        return $this->db->count_all_results($this->table);
    }

    /**
     * Mengupdate data kuliner. Dipakai oleh Admin dan UMKM.
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update_kuliner($id, $data)
    {
        if (empty($data) || empty($id)) {
            return false;
        }
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Menghapus data kuliner. Dipakai oleh Admin.
     * @param int $id
     * @return bool
     */
    public function delete_kuliner($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    /**
     * Menghapus semua kuliner milik user tertentu.
     * @param int $id_user
     * @return bool
     */
    public function delete_kuliner_by_user($id_user)
    {
        return $this->db->delete($this->table, ['id_user' => $id_user]);
    }


    /*
    |--------------------------------------------------------------------------
    | FUNGSI-FUNGSI UNTUK UMKM (DASHBOARD PENGGUNA)
    |--------------------------------------------------------------------------
    */

    /**
     * Mengambil semua kuliner milik user tertentu.
     * @param int $id_user
     * @return array
     */
    public function get_kuliner_by_user($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->order_by('updated_at', 'DESC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Mengambil satu data kuliner untuk memastikan kepemilikan.
     * @param int $id
     * @param int $id_user
     * @return object|null
     */
    public function get_kuliner_by_id_and_user($id, $id_user)
    {
        return $this->db->get_where($this->table, ['id' => $id, 'id_user' => $id_user])->row();
    }

    /**
     * Menyimpan data kuliner baru.
     * @param array $data
     * @return int|bool
     */
    public function insert_kuliner($data)
    {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | FUNGSI UNTUK PUBLIK (PETA, PENCARIAN, DLL)
    | Semua fungsi di bawah ini HANYA akan mengambil data yang sudah VERIFIED.
    |--------------------------------------------------------------------------
    */

    /**
     * Mengambil semua kuliner yang sudah diverifikasi untuk ditampilkan di peta.
     * @return array
     */
    public function get_all_for_map()
    {
        $this->db->where('status_verifikasi', 'verified');
        return $this->db->get($this->table)->result();
    }

    /**
     * Mengambil data detail kuliner yang sudah diverifikasi.
     * @param int $id
     * @return object|null
     */
    public function get_detail_for_public($id)
    {
        $this->db->where('status_verifikasi', 'verified');
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Mencari kuliner terverifikasi berdasarkan keyword.
     * @param string $keyword
     * @return array
     */
    public function search_verified_kuliner($keyword)
    {
        $this->db->where('status_verifikasi', 'verified');
        $this->db->group_start();
        $this->db->like('nama_kuliner', $keyword);
        $this->db->or_like('alamat', $keyword);
        $this->db->or_like('kategori', $keyword);
        $this->db->or_like('kecamatan', $keyword);
        $this->db->group_end();
        return $this->db->get($this->table)->result();
    }

    /**
     * Mengambil data Kategori UNIK dari kuliner yang sudah diverifikasi.
     * @return array
     */
    public function get_active_categories()
    {
        $this->db->select('kategori');
        $this->db->distinct();
        $this->db->where('status_verifikasi', 'verified');
        $this->db->where('kategori IS NOT NULL');
        $this->db->where('kategori !=', '');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    /**
     * Mengambil data Kecamatan UNIK dari kuliner yang sudah diverifikasi.
     * @return array
     */
    public function get_active_districts()
    {
        $this->db->select('kecamatan');
        $this->db->distinct();
        $this->db->where('status_verifikasi', 'verified');
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    /**
     * Mengambil kuliner terverifikasi terdekat berdasarkan koordinat pengguna.
     * @param float $lat Latitude pengguna
     * @param float $lon Longitude pengguna
     * @param int $radius Radius pencarian dalam kilometer
     * @return array
     */
    public function get_verified_nearby_kuliner($lat, $lon, $radius = 10)
    {
        // Haversine formula untuk menghitung jarak
        $this->db->select("
            *, 
            (
                6371 * acos(
                    cos(radians(" . $this->db->escape($lat) . ")) * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $this->db->escape($lon) . ")) + 
                    sin(radians(" . $this->db->escape($lat) . ")) * sin(radians(latitude))
                )
            ) AS distance
        ");

        // PENTING: Hanya ambil yang sudah diverifikasi
        $this->db->where('status_verifikasi', 'verified');

        $this->db->having('distance <=', $radius);
        $this->db->order_by('distance', 'ASC');
        $this->db->limit(20); // Batasi hasil

        return $this->db->get($this->table)->result();
    }
}
