<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Dashboard'; ?> - Pendaftaran Kuliner</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        :root {
            --primary-color: #2c5530;
            --secondary-color: #4a7c59;
            --background-color: #f4f7f6;
            --text-color: #333;
            --card-bg-color: #ffffff;
            --border-color: #e0e0e0;
            --header-height: 60px;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        /* ... CSS lainnya tetap sama ... */

        .site-header {
            background: linear-gradient(135deg, #2c5530, #4a7c59);
            color: white;
            height: var(--header-height);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1001;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-sizing: border-box;
        }

        .site-header .logo {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .site-header .logo a,
        .site-header .user-nav a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .site-header .user-nav {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .site-header .user-nav a:hover {
            text-decoration: underline;
        }

        .sidebar {
            width: 250px;
            background-color: var(--primary-color);
            height: calc(100vh - var(--header-height));
            position: fixed;
            top: var(--header-height);
            left: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 1.5rem;
            color: white;
            font-weight: 600;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            flex-grow: 1;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            transition: background-color 0.2s, padding-left 0.2s;
            font-weight: 500;
        }

        .sidebar-menu a:hover {
            background-color: var(--secondary-color);
        }

        .sidebar-menu a.active {
            background-color: var(--secondary-color);
            font-weight: 700;
            padding-left: 25px;
        }

        .sidebar-menu a i {
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            margin-top: var(--header-height);
            flex-grow: 1;
            padding: 20px;
            max-width: calc(100% - 250px);
        }

        .content-container {
            background-color: var(--card-bg-color);
            padding: 30px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .content-container h1 {
            margin-top: 0;
            font-size: 1.8rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .form-section-header {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-top: 30px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
            display: inline-block;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 5px rgba(44, 85, 48, 0.25);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-actions {
            grid-column: 1 / -1;
            text-align: right;
            margin-top: 30px;
            border-top: 1px solid var(--border-color);
            padding-top: 20px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }

        /* PENAMBAHAN CSS UNTUK STATUS */
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
            text-transform: capitalize;
        }

        .status-verified {
            background-color: #28a745;
            /* Hijau */
        }

        .status-pending {
            background-color: #ffc107;
            /* Kuning */
            color: #333;
        }

        .status-rejected {
            background-color: #dc3545;
            /* Merah */
        }
    </style>
</head>

<body>
    <header class="site-header">
        <div class="logo">
            <a href="<?= site_url() ?>">
                <i class="fas fa-utensils"></i>
                <span>HalalCulinary Depok</span>
            </a>
        </div>
        <nav class="user-nav">
            <a href="<?= site_url() ?>">
                <i class="fas fa-home"></i>
                <span>Kembali ke Beranda</span>
            </a>
            <a href="<?= site_url('auth/logout') ?>">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </nav>
    </header>

    <aside class="sidebar">
        <div class="sidebar-header">
            <h3>Dashboard UMKM</h3>
        </div>

        <?php
        // $active_page sudah dikirim dari controller
        ?>
        <ul class="sidebar-menu">
            <li>
                <a href="<?= site_url('umkm/tambah_kuliner') ?>" class="<?= ($active_page == 'daftar_usaha' || $active_page == 'edit_usaha') ? 'active' : '' ?>">
                    <i class="fas fa-plus-circle"></i>
                    <span>Daftarkan Usaha</span>
                </a>
            </li>
            <li>
                <a href="<?= site_url('umkm/list_kuliner') ?>" class="<?= ($active_page == 'outlet_saya' || $active_page == 'detail_usaha') ? 'active' : '' ?>">
                    <i class="fas fa-store"></i>
                    <span>Outlet Saya</span>
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <?php if ($active_page == 'daftar_usaha' || $active_page == 'edit_usaha') : ?>
            <div class="content-container">

                <h1><?= ($active_page == 'edit_usaha') ? 'Edit Usaha Kuliner' : 'Pendaftaran Usaha Kuliner'; ?></h1>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>
                <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <?php
                $action_url = ($active_page == 'edit_usaha' && isset($outlet))
                    ? site_url('umkm/proses_update')
                    : site_url('umkm/proses_simpan');
                ?>
                <form action="<?= $action_url ?>" method="post" enctype="multipart/form-data">

                    <?php if ($active_page == 'edit_usaha' && isset($outlet)): ?>
                        <input type="hidden" name="id" value="<?= $outlet->id; ?>">
                        <input type="hidden" name="foto_lama" value="<?= $outlet->foto; ?>">
                    <?php endif; ?>

                    <h3 class="form-section-header">Informasi Usaha</h3>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="nama_kuliner">Nama Usaha Kuliner</label>
                            <input type="text" id="nama_kuliner" name="nama_kuliner" value="<?= isset($outlet) ? htmlspecialchars($outlet->nama_kuliner) : set_value('nama_kuliner'); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <?php $kategori_val = isset($outlet) ? $outlet->kategori : set_value('kategori'); ?>
                                <option value="Cafe" <?= ($kategori_val == 'Cafe') ? 'selected' : ''; ?>>Cafe</option>
                                <option value="Fast Food" <?= ($kategori_val == 'Fast Food') ? 'selected' : ''; ?>>Fast Food</option>
                                <option value="Restoran" <?= ($kategori_val == 'Restoran') ? 'selected' : ''; ?>>Restoran</option>
                                <option value="Tradisional" <?= ($kategori_val == 'Tradisional') ? 'selected' : ''; ?>>Tradisional</option>
                                <option value="Warung" <?= ($kategori_val == 'Warung') ? 'selected' : ''; ?>>Warung</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jam_buka">Jam Buka</label>
                            <input type="text" id="jam_buka" name="jam_buka" placeholder="Contoh: 08:00 - 22:00" value="<?= isset($outlet) ? htmlspecialchars($outlet->jam_buka) : set_value('jam_buka'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="harga">Rentang Harga</label>
                            <select id="harga" name="harga" required>
                                <?php $harga_val = isset($outlet) ? $outlet->harga : set_value('harga'); ?>
                                <option value="murah" <?= ($harga_val == 'murah') ? 'selected' : ''; ?>>
                                    < Rp 25.000</option>
                                <option value="sedang" <?= ($harga_val == 'sedang') ? 'selected' : ''; ?>>Rp 25.000 - Rp 50.000</option>
                                <option value="mahal" <?= ($harga_val == 'mahal') ? 'selected' : ''; ?>>> Rp 50.000</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto Utama Usaha (Max: 2MB)</label>
                            <input type="file" id="foto" name="foto" accept="image/jpeg,image/png">
                            <?php if (isset($outlet) && !empty($outlet->foto)): ?>
                                <small>Foto saat ini: <a href="<?= base_url('uploads/kuliner/' . $outlet->foto) ?>" target="_blank"><?= $outlet->foto ?></a>. Kosongkan jika tidak ingin mengubah foto.</small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h3 class="form-section-header">Detail Lokasi</h3>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="alamat">Alamat Lengkap Usaha</label>
                            <textarea id="alamat" name="alamat" required><?= isset($outlet) ? htmlspecialchars($outlet->alamat) : set_value('alamat'); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan" required>
                                <option value="">Pilih Kecamatan</option>
                                <?php $kecamatan_val = isset($outlet) ? $outlet->kecamatan : set_value('kecamatan'); ?>
                                <option value="Beji" <?= ($kecamatan_val == 'Beji') ? 'selected' : ''; ?>>Beji</option>
                                <option value="Bojongsari" <?= ($kecamatan_val == 'Bojongsari') ? 'selected' : ''; ?>>Bojongsari</option>
                                <option value="Cilodong" <?= ($kecamatan_val == 'Cilodong') ? 'selected' : ''; ?>>Cilodong</option>
                                <option value="Cimanggis" <?= ($kecamatan_val == 'Cimanggis') ? 'selected' : ''; ?>>Cimanggis</option>
                                <option value="Cinere" <?= ($kecamatan_val == 'Cinere') ? 'selected' : ''; ?>>Cinere</option>
                                <option value="Cipayung" <?= ($kecamatan_val == 'Cipayung') ? 'selected' : ''; ?>>Cipayung</option>
                                <option value="Limo" <?= ($kecamatan_val == 'Limo') ? 'selected' : ''; ?>>Limo</option>
                                <option value="Pancoran Mas" <?= ($kecamatan_val == 'Pancoran Mas') ? 'selected' : ''; ?>>Pancoran Mas</option>
                                <option value="Sawangan" <?= ($kecamatan_val == 'Sawangan') ? 'selected' : ''; ?>>Sawangan</option>
                                <option value="Sukmajaya" <?= ($kecamatan_val == 'Sukmajaya') ? 'selected' : ''; ?>>Sukmajaya</option>
                                <option value="Tapos" <?= ($kecamatan_val == 'Tapos') ? 'selected' : ''; ?>>Tapos</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="map">Link Google Maps</label>
                            <input type="url" id="map" name="map" placeholder="https://maps.app.goo.gl/xxxx" value="<?= isset($outlet) ? htmlspecialchars($outlet->map) : set_value('map'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" id="latitude" name="latitude" placeholder="Contoh: -6.12345" value="<?= isset($outlet) ? htmlspecialchars($outlet->latitude) : set_value('latitude'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" id="longitude" name="longitude" placeholder="Contoh: 106.12345" value="<?= isset($outlet) ? htmlspecialchars($outlet->longitude) : set_value('longitude'); ?>">
                        </div>
                    </div>

                    <h3 class="form-section-header">Sertifikasi Halal</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="sertifikat">Status Sertifikat</label>
                            <select id="sertifikat" name="sertifikat" required>
                                <?php $sertifikat_val = isset($outlet) ? $outlet->sertifikat : set_value('sertifikat'); ?>
                                <option value="Belum Tersertifikasi" <?= ($sertifikat_val == 'Belum Tersertifikasi') ? 'selected' : ''; ?>>Belum Tersertifikasi</option>
                                <option value="BPJPH" <?= ($sertifikat_val == 'BPJPH') ? 'selected' : ''; ?>>BPJPH</option>
                                <option value="MUI" <?= ($sertifikat_val == 'MUI') ? 'selected' : ''; ?>>MUI</option>
                                <option value="Self-Declare" <?= ($sertifikat_val == 'Self-Declare') ? 'selected' : ''; ?>>Self-Declare</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_sertifikat">Nomor Sertifikat</label>
                            <input type="text" id="id_sertifikat" name="id_sertifikat" value="<?= isset($outlet) ? htmlspecialchars($outlet->id_sertifikat) : set_value('id_sertifikat'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="berlaku_sertifikat">Berlaku Sampai</label>
                            <input type="date" id="berlaku_sertifikat" name="berlaku_sertifikat" value="<?= isset($outlet) ? htmlspecialchars($outlet->berlaku_sertifikat) : set_value('berlaku_sertifikat'); ?>">
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="<?= site_url('umkm/list_kuliner') ?>" style="display: inline-block; margin-right: 15px; color: #333; text-decoration: none;">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <?= ($active_page == 'edit_usaha') ? 'Update Data Usaha' : 'Simpan Data Usaha'; ?>
                        </button>
                    </div>
                </form>
            </div>

        <?php elseif ($active_page == 'detail_usaha') : ?>
            <div class="content-container">
                <h1>Detail Usaha Kuliner</h1>

                <?php if (isset($outlet)): ?>
                    <table style="width:100%; border-collapse: collapse; font-size: 1rem;">

                        <tr>
                            <th style="width: 30%; text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd;">Nama Usaha</th>
                            <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($outlet->nama_kuliner) ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd; vertical-align: top;">Foto</th>
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <?php if (!empty($outlet->foto)): ?>
                                    <img src="<?= base_url('uploads/kuliner/' . $outlet->foto) ?>" alt="<?= htmlspecialchars($outlet->nama_kuliner) ?>" width="250" style="border-radius: 5px; border: 1px solid #ccc;">
                                <?php else: ?>
                                    <em>Tidak ada gambar</em>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd;">Status Verifikasi</th>
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <?php
                                $status = $outlet->status_verifikasi;
                                $badge_class = 'status-pending'; // Default
                                if ($status == 'verified') {
                                    $badge_class = 'status-verified';
                                } elseif ($status == 'rejected') {
                                    $badge_class = 'status-rejected';
                                }
                                ?>
                                <span class="status-badge <?= $badge_class ?>">
                                    <?= htmlspecialchars(ucfirst($status)) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd;">Kategori</th>
                            <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($outlet->kategori) ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd;">Jam Operasional</th>
                            <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($outlet->jam_buka ?: '-') ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd;">Rentang Harga</th>
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <?php
                                $harga_display = [
                                    'murah'  => '< Rp 25.000',
                                    'sedang' => 'Rp 25.000 - Rp 50.000',
                                    'mahal'  => '> Rp 50.000'
                                ];
                                echo isset($harga_display[$outlet->harga]) ? $harga_display[$outlet->harga] : htmlspecialchars($outlet->harga);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2" style="padding: 15px 12px; background-color: #e9ecef; border: 1px solid #ddd; text-align: left; font-size: 1.1rem; color: var(--primary-color);">Detail Lokasi</th>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd; vertical-align: top;">Alamat Lengkap</th>
                            <td style="padding: 12px; border: 1px solid #ddd; line-height: 1.6;"><?= nl2br(htmlspecialchars($outlet->alamat)) ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd;">Kecamatan</th>
                            <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($outlet->kecamatan) ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd;">Koordinat</th>
                            <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($outlet->latitude) ?>, <?= htmlspecialchars($outlet->longitude) ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd;">Link Google Maps</th>
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <?php if (!empty($outlet->map)): ?>
                                    <a href="<?= htmlspecialchars($outlet->map) ?>" target="_blank" style="color: #2980b9; text-decoration: none;">Lihat di Peta <i class="fas fa-external-link-alt"></i></a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2" style="padding: 15px 12px; background-color: #e9ecef; border: 1px solid #ddd; text-align: left; font-size: 1.1rem; color: var(--primary-color);">Sertifikasi Halal</th>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd;">Lembaga Sertifikasi</th>
                            <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($outlet->sertifikat ?: '-') ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd;">Nomor Sertifikat</th>
                            <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($outlet->id_sertifikat ?: '-') ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 12px; background-color: #f9f9f9; border: 1px solid #ddd;">Berlaku Sampai</th>
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <?= !empty($outlet->berlaku_sertifikat) ? date('d F Y', strtotime($outlet->berlaku_sertifikat)) : '-' ?>
                            </td>
                        </tr>

                    </table>

                    <div class="form-actions" style="border-top: none; padding-top: 30px; text-align: left;">
                        <a href="<?= site_url('umkm/list_kuliner') ?>" class="btn btn-primary" style="background-color: var(--secondary-color);">
                            <i class="fas fa-arrow-left"></i> Kembali ke Outlet Saya
                        </a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">Data outlet tidak ditemukan.</div>
                <?php endif; ?>
            </div>

        <?php elseif ($active_page == 'outlet_saya') : ?>

            <div class="content-container">
                <h1>Outlet Saya</h1>
                <p>Berikut adalah daftar usaha kuliner yang telah Anda daftarkan.</p>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <?php if (empty($outlets)): ?>
                    <div class="alert alert-info">
                        Anda belum memiliki outlet yang terdaftar.
                        <a href="<?= site_url('umkm/tambah_kuliner') ?>">Daftarkan usaha pertama Anda di sini!</a>
                    </div>
                <?php else: ?>
                    <div class="outlet-list">
                        <table style="width:100%; border-collapse: collapse; margin-top: 20px;">
                            <thead style="background-color: #f4f7f6;">
                                <tr>
                                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Foto</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Nama Usaha</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Kategori</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Status</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($outlets as $outlet): ?>
                                    <tr>
                                        <td style="padding: 10px; border-bottom: 1px solid #e0e0e0;">
                                            <?php if (!empty($outlet->foto)): ?>
                                                <img src="<?= base_url('uploads/kuliner/' . $outlet->foto) ?>" alt="<?= htmlspecialchars($outlet->nama_kuliner) ?>" width="80" style="border-radius: 5px;">
                                            <?php else: ?>
                                                <img src="<?= base_url('assets/images/no-image.png') ?>" alt="Tidak ada gambar" width="80" style="border-radius: 5px; border: 1px solid #ddd;">
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding: 10px; border-bottom: 1px solid #e0e0e0; font-weight: 600; color: var(--primary-color);"><?= htmlspecialchars($outlet->nama_kuliner) ?></td>
                                        <td style="padding: 10px; border-bottom: 1px solid #e0e0e0;"><?= htmlspecialchars($outlet->kategori) ?></td>

                                        <td style="padding: 10px; border-bottom: 1px solid #e0e0e0;">
                                            <?php
                                            $status = $outlet->status_verifikasi;
                                            $badge_class = 'status-pending'; // Default
                                            if ($status == 'verified') {
                                                $badge_class = 'status-verified';
                                            } elseif ($status == 'rejected') {
                                                $badge_class = 'status-rejected';
                                            }
                                            ?>
                                            <span class="status-badge <?= $badge_class ?>">
                                                <?= htmlspecialchars($status) ?>
                                            </span>
                                        </td>

                                        <td style="padding: 10px; border-bottom: 1px solid #e0e0e0; white-space: nowrap;">
                                            <a href="<?= site_url('umkm/detail/' . $outlet->id) ?>" style="color: #2980b9; text-decoration:none; font-weight: bold; margin-right: 8px;" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= site_url('umkm/edit_kuliner/' . $outlet->id) ?>" style="color: #4a7c59; text-decoration:none; font-weight: bold; margin-right: 8px;" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= site_url('umkm/hapus_kuliner/' . $outlet->id) ?>" style="color: #c0392b; text-decoration:none; font-weight: bold;" onclick="return confirm('Anda yakin ingin menghapus outlet ini? Data yang dihapus tidak dapat dikembalikan.')" title="Hapus Data">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

        <?php endif; ?>
    </main>

</body>

</html>