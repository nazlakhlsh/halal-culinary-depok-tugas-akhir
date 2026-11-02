<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HalalCulinary Depok - Sistem Informasi Spasial Kuliner Halal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }

        .header {
            background: linear-gradient(135deg, #2c5530, #4a7c59);
            color: white;
            padding: 0.75rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .logo img {
            height: 45px;
            width: auto;
        }

        /* --- REVISI: Mengatur .nav-menu sebagai container utama untuk semua link --- */
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
            /* Menjaga semua item sejajar di tengah secara vertikal */
            margin: 0;
            padding: 0;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 500;
            display: block;
            /* Memastikan padding bekerja dengan baik */
        }

        .nav-menu a:hover {
            color: #a8d5a8;
        }

        /* --- REVISI: Menghapus style .nav-auth karena sudah digabung ke .nav-menu --- */
        /* .nav-auth { ... } << Dihapus */

        /* --- REVISI: Mengubah selector agar lebih fleksibel dan tidak bergantung pada .nav-auth --- */

        .nav-menu a.btn-login,
        .nav-menu a.btn-dashboard {
            padding: 0.5rem 1.2rem;
            border-radius: 20px;
            border: 2px solid transparent;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        /* Gaya untuk tombol "Login / Daftar" (solid/utama) */
        .nav-menu a.btn-login {
            background-color: white;
            color: #2c5530;
            border-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .nav-menu a.btn-login:hover {
            background-color: #f0f0f0;
            color: #2c5530;
            /* Pastikan warna teks tidak berubah saat hover */
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Gaya untuk tombol Dashboard */
        .nav-menu a.btn-dashboard {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background-color: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .nav-menu a.btn-dashboard:hover {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        /* Gaya untuk tombol Logout */
        .nav-menu a.btn-logout {
            color: #ffcaca;
            padding: 0;
            border: none;
            background: none;
        }

        .nav-menu a.btn-logout:hover {
            color: white;
            text-decoration: underline;
        }


        /* SISA CSS TETAP SAMA */
        .container {
            margin-top: 80px;
        }

        .hero {
            background: white;
            padding: 3rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .container-hero {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: stretch;
        }

        .hero-image {
            display: flex;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 30% center;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .hero-text h1 {
            font-size: 2.5rem;
            color: #2c5530;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .hero-text p {
            margin-bottom: 1rem;
            color: #666;
            font-size: 1.1rem;
        }

        .features {
            margin: 2rem 0;
        }

        .features h3 {
            color: #2c5530;
            margin-bottom: 1rem;
        }

        .feature-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
        }

        .feature-item i {
            color: #4a7c59;
            width: 20px;
        }

        .about-halal,
        .sertifikasi-section {
            padding: 4rem 0;
            position: relative;
        }

        .about-halal {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .sertifikasi-section {
            background: white;
        }

        .about-halal::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2c5530, #4a7c59, #2c5530);
        }

        .about-halal-container,
        .sertifikasi-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .about-halal .section-title,
        .sertifikasi-section .section-title {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
        }

        .about-halal .section-title::after,
        .sertifikasi-section .section-title::after {
            content: "";
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #2c5530, #4a7c59);
            display: block;
            margin: 1rem auto 0;
            border-radius: 2px;
        }

        .about-halal .section-title h2,
        .sertifikasi-section .section-title h2 {
            font-size: 2.8rem;
            color: #2c5530;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .about-halal .section-title h2 i,
        .sertifikasi-section .section-title h2 i {
            font-size: 2.4rem;
            color: #4a7c59;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .about-halal .section-title p,
        .sertifikasi-section .section-title p {
            font-size: 1.2rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.7;
            font-weight: 400;
        }

        .halal-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .halal-card {
            background: white;
            padding: 2.5rem 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(44, 85, 48, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(74, 124, 89, 0.1);
        }

        .halal-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2c5530, #4a7c59);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .halal-card:hover::before {
            transform: scaleX(1);
        }

        .halal-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(44, 85, 48, 0.2);
            border-color: #4a7c59;
        }

        .halal-card i {
            font-size: 3rem;
            color: #4a7c59;
            margin-bottom: 1.5rem;
            display: block;
            transition: all 0.3s ease;
        }

        .halal-card:hover i {
            transform: scale(1.1);
            color: #2c5530;
        }

        .halal-card h3 {
            font-size: 1.4rem;
            color: #2c5530;
            margin-bottom: 1rem;
            font-weight: 600;
            line-height: 1.3;
        }

        .halal-card p {
            color: #666;
            line-height: 1.7;
            font-size: 1rem;
            margin: 0;
        }

        .halal-principles {
            background: white;
            padding: 3rem 2.5rem;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(44, 85, 48, 0.1);
            margin-bottom: 3rem;
            position: relative;
            border: 1px solid rgba(74, 124, 89, 0.1);
        }

        .halal-principles::before {
            content: "";
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, #2c5530, #4a7c59, #2c5530);
            border-radius: 25px;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .halal-principles:hover::before {
            opacity: 0.1;
        }

        .halal-principles h3 {
            font-size: 2rem;
            color: #2c5530;
            margin-bottom: 2.5rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            font-weight: 600;
        }

        .halal-principles h3 i {
            font-size: 1.8rem;
            color: #4a7c59;
        }

        .principles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .principle-item {
            text-align: center;
            padding: 2rem 1.5rem;
            border-radius: 15px;
            border: 2px solid transparent;
            background: #f8f9fa;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .principle-item::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(74, 124, 89, 0.1);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.6s ease;
            z-index: 0;
        }

        .principle-item:hover::before {
            width: 200%;
            height: 200%;
        }

        .principle-item:hover {
            background: white;
            border-color: #4a7c59;
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(44, 85, 48, 0.15);
        }

        .principle-item>* {
            position: relative;
            z-index: 1;
        }

        .principle-item i {
            font-size: 2.5rem;
            color: #4a7c59;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .principle-item:hover i {
            transform: scale(1.2);
            color: #2c5530;
        }

        .principle-item h4 {
            font-size: 1.2rem;
            color: #2c5530;
            margin-bottom: 0.8rem;
            font-weight: 600;
        }

        .principle-item p {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
            margin: 0;
        }

        .certification-info {
            background: linear-gradient(135deg, white 0%, #f8f9fa 100%);
            padding: 3rem 2.5rem;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(44, 85, 48, 0.1);
            text-align: center;
            border: 1px solid rgba(74, 124, 89, 0.1);
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }

        .certification-info::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2c5530, #4a7c59, #2c5530);
            border-radius: 0 0 25px 25px;
        }

        .certification-info h3 {
            font-size: 2rem;
            color: #2c5530;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            font-weight: 600;
        }

        .certification-info h3 i {
            font-size: 1.8rem;
            color: #4a7c59;
            animation: rotate 3s linear infinite;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .certification-info p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2.5rem;
            line-height: 1.8;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .halal-logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .halal-logo {
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(44, 85, 48, 0.15);
            border: 3px solid #4a7c59;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .halal-logo:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 12px 35px rgba(44, 85, 48, 0.25);
        }

        .halal-logo::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(74, 124, 89, 0.1), transparent);
            animation: spinBorder 3s linear infinite;
            z-index: 1;
        }

        @keyframes spinBorder {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .halal-logo img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            position: relative;
            z-index: 2;
            border-radius: 8px;
        }

        .halal-logo-placeholder {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #4a7c59, #2c5530);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            position: relative;
            z-index: 2;
        }

        .cert-logos {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .cert-logo {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 15px;
            border: 2px solid #e0e0e0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 120px;
            position: relative;
            overflow: hidden;
        }

        .cert-logo::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(74, 124, 89, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .cert-logo:hover::before {
            left: 100%;
        }

        .cert-logo:hover {
            border-color: #4a7c59;
            background: linear-gradient(135deg, #f0f8f0, white);
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(44, 85, 48, 0.15);
        }

        .cert-logo strong {
            color: #2c5530;
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .cert-logo small {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .sertifikasi-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .sertifikasi-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .sertifikasi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .sertifikasi-card h3 {
            color: #2c5530;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            text-align: center;
        }

        .sertifikasi-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .main-content .section-title {
            grid-column: 1 / -1;
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .main-content .section-title h2 {
            color: #2c5530;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .main-content .section-title h2 i {
            font-size: 2.4rem;
            color: #4a7c59;
            animation: pulse 2s infinite;
        }

        .main-content .section-title h2::after {
            content: '';
            position: absolute;
            bottom: 2.5rem;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #4a7c59, #6ba368);
            border-radius: 2px;
        }

        .main-content .section-subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-top: -1rem;
            font-weight: 400;
        }

        .map-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            height: 600px;
        }

        #mapid {
            height: 100%;
            width: 100%;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .filter-section,
        .outlet-list {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .filter-section h3,
        .outlet-list h3 {
            color: #2c5530;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-group {
            margin-bottom: 1rem;
        }

        .filter-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            outline: none;
            border-color: #4a7c59;
        }

        .outlet-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .outlet-item {
            padding: 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .outlet-item:hover {
            background-color: #f8f9fa;
            border-color: #4a7c59;
            transform: translateY(-2px);
        }

        .outlet-name {
            font-weight: bold;
            color: #2c5530;
            margin-bottom: 0.5rem;
        }

        .outlet-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.3rem;
            color: #666;
            font-size: 0.9rem;
        }

        .outlet-info i {
            color: #4a7c59;
            width: 15px;
        }

        .popup-content {
            font-family: inherit;
        }

        .popup-title {
            font-weight: bold;
            color: #2c5530;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .popup-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.3rem;
            color: #666;
        }

        .popup-info i {
            color: #4a7c59;
            width: 15px;
        }

        .halal-badge {
            background: #4a7c59;
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
            margin-left: auto;
        }

        .footer {
            background: #2c5530;
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }

            .container-hero {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .hero-text h1 {
                font-size: 2rem;
            }

            .about-halal,
            .sertifikasi-section {
                padding: 3rem 0;
            }

            .about-halal-container,
            .sertifikasi-container {
                padding: 0 1rem;
            }

            .about-halal .section-title h2,
            .sertifikasi-section .section-title h2 {
                font-size: 2.2rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .halal-content,
            .sertifikasi-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                margin-bottom: 3rem;
            }

            .halal-card,
            .sertifikasi-card {
                padding: 2rem 1.5rem;
            }

            .halal-principles {
                padding: 2rem 1.5rem;
                margin-bottom: 2rem;
            }

            .principles-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .certification-info {
                padding: 2rem 1.5rem;
            }

            .certification-info h3 {
                font-size: 1.5rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .halal-logo {
                width: 120px;
                height: 120px;
            }

            .halal-logo img,
            .halal-logo-placeholder {
                width: 80px;
                height: 80px;
            }

            .cert-logos {
                gap: 1rem;
                flex-direction: column;
                align-items: center;
            }

            .main-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 0 1rem;
            }

            .main-content .section-title {
                margin-bottom: 1.5rem;
            }

            .main-content .section-title h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="nav-container">
            <div class="logo">
                <a href="<?= site_url() ?>" style="color: white; text-decoration: none;">
                    <i class="fas fa-utensils"></i>
                    <span>HalalCulinary Depok</span>
                </a>
            </div>

            <nav>
                <ul class="nav-menu">
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#tentang-halal">Tentang Halal</a></li>
                    <li><a href="#sertifikasi">Sertifikasi</a></li>
                    <li><a href="#peta">Peta Kuliner</a></li>

                    <?php
                    // Memeriksa apakah ada session dengan key 'is_logged_in'
                    if ($this->session->userdata('is_logged_in')):
                    ?>
                        <li>
                            <?php
                            // Cek role dari session untuk menentukan URL dashboard yang benar
                            $dashboard_url = ($this->session->userdata('role') === 'admin') ? site_url('admin') : site_url('umkm');
                            ?>
                            <a href="<?= $dashboard_url ?>" class="btn-dashboard">
                                <i class="fas fa-user-circle"></i>
                                <span><?= $this->session->userdata('nama_lengkap') ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('auth/logout') ?>" class="btn-logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?= site_url('auth/login') ?>" class="btn-login">Login / Daftar</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <section class="hero" id="home">
            <div class="container-hero">
                <div class="hero-image">
                    <img src="assets/images/9150493.jpg" alt="Kuliner Halal" />
                </div>
                <div class="hero-text">
                    <h1><i class="fas fa-map-marker-alt"></i> HalalCulinary Depok</h1>
                    <p>
                        HalalCulinary Depok adalah sistem informasi spasial berbasis web yang menyajikan data sebaran
                        outlet kuliner halal di seluruh Kota Depok. Platform ini dikembangkan untuk membantu masyarakat
                        Muslim dan wisatawan dalam menemukan tempat makan halal dengan mudah dan akurat.
                    </p>
                    <p>
                        Sistem ini menampilkan informasi lengkap seperti lokasi, kategori kuliner, harga, rating, dan
                        sertifikasi halal. Disajikan melalui peta interaktif serta fitur pencarian yang memudahkan
                        pengguna.
                    </p>

                    <div class="features">
                        <h3>✨ Fitur Utama:</h3>
                        <div class="feature-list">
                            <div class="feature-item"><i class="fas fa-map-marked-alt"></i><span>Peta interaktif lokasi
                                    kuliner halal</span></div>
                            <div class="feature-item"><i class="fas fa-filter"></i><span>Filter kategori, kecamatan,
                                    harga</span></div>
                            <div class="feature-item"><i class="fas fa-info-circle"></i><span>Detail outlet: alamat,
                                    kontak, jam</span></div>
                            <div class="feature-item"><i class="fas fa-search"></i><span>Pencarian outlet berdasarkan
                                    nama</span></div>
                        </div>
                    </div>

                    <div class="umkm-invitation" style="background: linear-gradient(135deg, #f0f8f0, #e8f5e8); padding: 1.5rem; border-radius: 15px; margin: 2rem 0; border: 2px solid #4a7c59; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: -50%; right: -50%; width: 100px; height: 100px; background: radial-gradient(circle, rgba(74, 124, 89, 0.1) 0%, transparent 70%); animation: pulse 3s infinite;"></div>
                        <div style="position: relative; z-index: 1;">
                            <h3 style="color: #2c5530; margin-bottom: 0.8rem; display: flex; align-items: center; gap: 0.5rem; font-size: 1.3rem;">
                                <i class="fas fa-store" style="color: #4a7c59;"></i>
                                Khusus Pelaku UMKM Kuliner Halal
                            </h3>
                            <p style="color: #555; margin-bottom: 1rem; line-height: 1.6;">
                                Punya usaha kuliner yang sudah <strong>bersertifikasi halal</strong>? Daftarkan outlet Anda di platform kami untuk menjangkau lebih banyak pelanggan dan meningkatkan visibilitas bisnis Anda!
                            </p>

                            <?php if ($this->session->userdata('is_logged_in')): ?>
                                <!-- Jika sudah login, arahkan ke dashboard -->
                                <a href="<?= site_url('dashboard') ?>"
                                    style="display: inline-flex; align-items: center; gap: 0.5rem; background: #4a7c59; color: white; padding: 0.8rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(74, 124, 89, 0.3);"
                                    onmouseover="this.style.background='#2c5530'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(74, 124, 89, 0.4)';"
                                    onmouseout="this.style.background='#4a7c59'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(74, 124, 89, 0.3)';">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Kelola Usaha Anda
                                </a>
                            <?php else: ?>
                                <!-- Jika belum login, arahkan ke login -->
                                <a href="<?= site_url('auth/login') ?>"
                                    style="display: inline-flex; align-items: center; gap: 0.5rem; background: #4a7c59; color: white; padding: 0.8rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(74, 124, 89, 0.3);"
                                    onmouseover="this.style.background='#2c5530'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(74, 124, 89, 0.4)';"
                                    onmouseout="this.style.background='#4a7c59'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(74, 124, 89, 0.3)';">
                                    <i class="fas fa-plus-circle"></i>
                                    Daftarkan Usaha Anda
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <p style="margin-top: 1rem;">
                        Yuk, gunakan aplikasi ini untuk mendukung gaya hidup halal dan memilih kuliner dengan lebih
                        bijak!
                    </p>
                </div>
            </div>
        </section>

        <section class="about-halal" id="tentang-halal">
            <div class="about-halal-container">
                <div class="section-title">
                    <h2><i class="fas fa-star-and-crescent"></i> Tentang Kuliner Halal</h2>
                    <p>Memahami makna, prinsip, dan pentingnya kuliner halal dalam kehidupan sehari-hari</p>
                </div>

                <div class="halal-content">
                    <div class="halal-card">
                        <i class="fas fa-book-open"></i>
                        <h3>Apa itu Halal?</h3>
                        <p>Halal berasal dari bahasa Arab yang berarti "diperbolehkan" atau "diizinkan" menurut syariat
                            Islam. Dalam konteks kuliner, halal merujuk pada makanan dan minuman yang diperbolehkan
                            dikonsumsi oleh umat Muslim sesuai dengan ketentuan Al-Qur'an dan Hadis.</p>
                    </div>

                    <div class="halal-card">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Jaminan Kualitas</h3>
                        <p>Makanan halal tidak hanya memenuhi aspek religius, tetapi juga menjamin kualitas, kebersihan,
                            dan keamanan pangan. Proses produksi halal mengutamakan sanitasi, higienitas, dan penggunaan
                            bahan-bahan yang berkualitas tinggi.</p>
                    </div>

                    <div class="halal-card">
                        <i class="fas fa-heart"></i>
                        <h3>Manfaat Kesehatan</h3>
                        <p>Konsep halal mendorong konsumsi makanan yang bersih, sehat, dan bergizi. Larangan terhadap
                            bahan-bahan tertentu dalam Islam seringkali sejalan dengan prinsip kesehatan modern, seperti
                            menghindari alkohol dan daging yang tidak sehat.</p>
                    </div>

                    <div class="halal-card">
                        <i class="fas fa-globe"></i>
                        <h3>Akseptabilitas Universal</h3>
                        <p>Makanan halal dapat dinikmati oleh siapa saja, tidak hanya umat Muslim. Standar halal yang
                            ketat membuat produk ini aman dan berkualitas untuk semua konsumen, menjadikannya pilihan
                            universal yang baik.</p>
                    </div>
                </div>

                <div class="halal-principles">
                    <h3><i class="fas fa-list-check"></i> Prinsip-Prinsip Makanan Halal</h3>
                    <div class="principles-grid">
                        <div class="principle-item"><i class="fas fa-ban"></i>
                            <h4>Bebas Babi</h4>
                            <p>Tidak mengandung daging babi atau turunannya</p>
                        </div>
                        <div class="principle-item"><i class="fas fa-wine-glass-empty"></i>
                            <h4>Tanpa Alkohol</h4>
                            <p>Tidak menggunakan alkohol dalam proses pembuatan</p>
                        </div>
                        <div class="principle-item"><i class="fas fa-cut"></i>
                            <h4>Penyembelihan Syar'i</h4>
                            <p>Hewan disembelih sesuai tuntunan Islam</p>
                        </div>
                        <div class="principle-item"><i class="fas fa-soap"></i>
                            <h4>Kebersihan</h4>
                            <p>Proses produksi yang bersih dan higienis</p>
                        </div>
                        <div class="principle-item"><i class="fas fa-microscope"></i>
                            <h4>Bahan Alami</h4>
                            <p>Menggunakan bahan-bahan yang tidak berbahaya</p>
                        </div>
                        <div class="principle-item"><i class="fas fa-handshake"></i>
                            <h4>Etika Bisnis</h4>
                            <p>Transaksi yang jujur dan adil</p>
                        </div>
                    </div>
                </div>

                <div class="certification-info">
                    <h3><i class="fas fa-certificate"></i> Sertifikasi Halal di Indonesia</h3>

                    <div class="halal-logo-container">
                        <div class="halal-logo">
                            <img src="assets/images/logo-halal.png" alt="Logo Halal"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="halal-logo-placeholder" style="display: none;">
                                <i class="fas fa-mosque"></i>
                            </div>
                        </div>
                    </div>

                    <p>
                        Di Indonesia, sertifikasi halal dikeluarkan oleh Badan Penyelenggara Jaminan Produk Halal
                        (BPJPH)
                        yang berada di bawah Kementerian Agama RI, dengan dukungan teknis dari Majelis Ulama Indonesia
                        (MUI).
                        Sertifikat halal menjamin bahwa produk tersebut telah melewati audit ketat dan memenuhi standar
                        halal.
                    </p>

                    <div class="cert-logos">
                        <div class="cert-logo">
                            <strong>BPJPH</strong>
                            <small>Kemenag RI</small>
                        </div>
                        <div class="cert-logo">
                            <strong>MUI</strong>
                            <small>Majelis Ulama Indonesia</small>
                        </div>
                        <div class="cert-logo">
                            <strong>LPPOM</strong>
                            <small>Lembaga Pengkajian</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="sertifikasi-section" id="sertifikasi">
            <div class="sertifikasi-container">
                <div class="section-title">
                    <h2><i class="fas fa-tasks"></i> Alur dan Syarat Sertifikasi Halal</h2>
                    <p>Panduan bagi pelaku usaha untuk mendaftarkan produknya agar tersertifikasi halal oleh BPJPH.</p>
                </div>

                <div class="sertifikasi-grid">
                    <div class="sertifikasi-card">
                        <h3>Sertifikasi Reguler</h3>
                        <img src="assets/images/alur-pendaftaran1.png" alt="Alur Sertifikasi Halal Reguler">
                    </div>
                    <div class="sertifikasi-card">
                        <h3>Dokumen Persyaratan (Reguler)</h3>
                        <img src="assets/images/dokumen-persyaratan.webp" alt="Dokumen Persyaratan Sertifikasi Reguler">
                    </div>
                    <div class="sertifikasi-card">
                        <h3>Sertifikasi Gratis (SEHATI)</h3>
                        <img src="assets/images/alur-pendaftaran2.webp" alt="Alur Sertifikasi Halal Gratis (SEHATI)">
                    </div>
                    <div class="sertifikasi-card">
                        <h3>Syarat Sertifikasi Gratis (SEHATI)</h3>
                        <img src="assets/images/syarat-sertifikasi.webp" alt="Syarat Sertifikasi Gratis (SEHATI)">
                    </div>
                </div>
            </div>
        </section>

        <section class="main-content" id="peta">
            <div class="section-title">
                <h2><i class="fas fa-map-marked-alt"></i> Peta Kuliner Interaktif</h2>
                <p class="section-subtitle">Jelajahi, cari, dan temukan ratusan outlet kuliner halal di seluruh Kota
                    Depok.</p>
            </div>

            <div class="map-container">
                <div id="mapid"></div>
            </div>

            <div class="sidebar">
                <div class="filter-section">
                    <h3><i class="fas fa-filter"></i> Filter Pencarian</h3>

                    <div class="filter-group">
                        <label for="kategori">Kategori Kuliner</label>
                        <select id="kategori">
                            <option value="">Semua Kategori</option>
                            <option value="Cafe">Cafe</option>
                            <option value="Fast Food">Fast Food</option>
                            <option value="Restoran">Restoran</option>
                            <option value="Tradisional">Tradisional</option>
                            <option value="Warung">Warung</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="kecamatan">Kecamatan</label>
                        <select id="kecamatan">
                            <option value="">Semua Kecamatan</option>
                            <option value="Beji">Beji</option>
                            <option value="Bojongsari">Bojongsari</option>
                            <option value="Cilodong">Cilodong</option>
                            <option value="Cimanggis">Cimanggis</option>
                            <option value="Cinere">Cinere</option>
                            <option value="Cipayung">Cipayung</option>
                            <option value="Limo">Limo</option>
                            <option value="Pancoran Mas">Pancoran Mas</option>
                            <option value="Sawangan">Sawangan</option>
                            <option value="Sukmajaya">Sukmajaya</option>
                            <option value="Tapos">Tapos</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="harga">Rentang Harga</label>
                        <select id="harga">
                            <option value="">Semua Harga</option>
                            <option value="murah">&lt; Rp 25.000</option>
                            <option value="sedang">Rp 25.000 - 50.000</option>
                            <option value="mahal">&gt; Rp 50.000</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="pencarian">Cari Nama Outlet</label>
                        <input type="text" id="pencarian" placeholder="Masukkan nama outlet...">
                    </div>
                    <div class="filter-group">
                        <button id="btnCariTerdekat" style="width: 100%; padding: 0.8rem; font-size: 1rem; background-color: #2c5530; color: white; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Gunakan Lokasi Saya</span>
                        </button>
                    </div>
                </div>

                <div class="outlet-list">
                    <h3><i class="fas fa-list"></i> Daftar Outlet</h3>
                    <div id="loading" style="text-align: center; padding: 2rem; display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Memuat data...
                    </div>
                    <div id="outlet-items">
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer">
            <p>&copy; 2025 HalalCulinary Depok.</p>
        </footer>
    </div>

    <script>
        // Variabel global untuk menyimpan data outlet
        let outletData = [];
        let filteredData = [];

        // Inisialisasi peta
        const map = L.map('mapid').setView([-6.3951, 106.8324], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Variabel untuk menyimpan markers
        let markers = [];

        // Fungsi untuk mengambil data dari database
        async function fetchOutletData() {
            const loadingElement = document.getElementById('loading');
            try {
                if (loadingElement) loadingElement.style.display = 'block';

                const baseUrl = window.location.origin;
                const pathArray = window.location.pathname.split('/');
                let projectPath = '';
                if (pathArray.length > 2 && pathArray[1] !== 'index.php') {
                    projectPath = '/' + pathArray[1];
                }
                const apiUrl = baseUrl + projectPath + '/api/get_all_verified';

                const response = await fetch(apiUrl);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                if (data.success && data.data) {
                    outletData = data.data.map((outlet, index) => ({
                        id: outlet.id || index,
                        nama: outlet.nama_kuliner || 'Kuliner Tanpa Nama',
                        kategori: (outlet.kategori || 'umum').toLowerCase(),
                        kecamatan: (outlet.kecamatan || 'unknown').toLowerCase().replace(/\s+/g, '-'),
                        lat: parseFloat(outlet.latitude || 0),
                        lng: parseFloat(outlet.longitude || 0),
                        alamat: outlet.alamat || 'Alamat tidak tersedia',
                        jamBuka: outlet.jam_buka || 'Tidak tersedia',
                        sertifikat: outlet.sertifikat || 'MUI',
                        idSertifikat: outlet.id_sertifikat || '',
                        berlakuSertifikat: outlet.berlaku_sertifikat || 'Tidak tersedia',
                        harga: (outlet.harga || 'menengah').toLowerCase(),
                        map: outlet.map || '',
                        deskripsi: outlet.deskripsi || '',
                        foto: outlet.foto || outlet.gambar || '',
                        telepon: outlet.telepon || outlet.phone || 'Tidak tersedia',
                        rating: parseFloat(outlet.rating || 0),
                        distance: outlet.distance
                    }));

                    const validOutlets = outletData.filter(outlet =>
                        outlet.lat && outlet.lng && !isNaN(outlet.lat) && !isNaN(outlet.lng)
                    );

                    addMarkers(validOutlets);
                    updateOutletList(outletData);
                    filteredData = [...outletData];
                    updateCounter(outletData.length);
                    populateFilterOptions(outletData);
                } else {
                    showError('Gagal memuat data: ' + (data.message || 'Response tidak valid'));
                }
            } catch (error) {
                showError(`Gagal mengambil data dari server: ${error.message}`);
            } finally {
                if (loadingElement) loadingElement.style.display = 'none';
            }
        }

        function populateFilterOptions(data) {
            const kategoriSelect = document.getElementById('kategori');
            if (kategoriSelect) {
                const categories = [...new Set(data.map(outlet => outlet.kategori))].sort();
                kategoriSelect.innerHTML = '<option value="">Semua Kategori</option>';
                categories.forEach(cat => {
                    if (cat) {
                        const option = document.createElement('option');
                        option.value = cat;
                        option.textContent = cat.charAt(0).toUpperCase() + cat.slice(1);
                        kategoriSelect.appendChild(option);
                    }
                });
            }
            const kecamatanSelect = document.getElementById('kecamatan');
            if (kecamatanSelect) {
                const districts = [...new Set(data.map(outlet => outlet.kecamatan))].sort();
                kecamatanSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
                districts.forEach(dist => {
                    if (dist && dist !== 'unknown') {
                        const option = document.createElement('option');
                        option.value = dist;
                        option.textContent = dist.charAt(0).toUpperCase() + dist.slice(1).replace(/-/g, ' ');
                        kecamatanSelect.appendChild(option);
                    }
                });
            }
        }

        function updateCounter(count) {
            const subtitle = document.querySelector('.main-content .section-subtitle');
            if (subtitle) {
                subtitle.textContent = `Ditemukan ${count} outlet kuliner halal di seluruh Kota Depok.`;
            }
        }

        function showError(message) {
            const container = document.getElementById('outlet-items');
            if (container) {
                container.innerHTML = `<div style="text-align: center; color: #e74c3c; padding: 2rem; border: 1px solid #e74c3c; border-radius: 5px; background-color: #fdf2f2; margin: 1rem;"><i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 1rem;"></i><br><strong>Error:</strong><br><br>${message}</div>`;
            }
        }

        function createPopupContent(outlet) {
            let berlakuText = '';
            if (outlet.berlakuSertifikat && outlet.berlakuSertifikat !== 'Tidak tersedia') {
                const date = new Date(outlet.berlakuSertifikat);
                if (!isNaN(date.getTime())) {
                    berlakuText = date.toLocaleDateString('id-ID');
                } else {
                    berlakuText = outlet.berlakuSertifikat;
                }
            }

            // Info jarak
            const distanceInfo = outlet.distance ? `
        <div class="popup-info" style="margin: 5px 0; display: flex; align-items: center; color: #c0392b; font-weight: bold;">
            <i class="fas fa-route" style="width: 20px;"></i>
            <span>Jarak: ${parseFloat(outlet.distance).toFixed(2)} km</span>
        </div>` : '';

            // Foto dengan ukuran yang sama
            const fotoContent = outlet.foto ? `
        <div class="popup-foto" style="margin: 10px 0; text-align: center;">
            <img src="${outlet.foto}" alt="${outlet.nama}" 
                 style="width: 200px; height: 150px; object-fit: cover; border-radius: 8px; border: 2px solid #ddd;"
                 onerror="this.style.display='none';">
        </div>` : '';

            return `
        <div class="popup-content" style="min-width: 250px; max-width: 300px;">
            <div class="popup-title" style="font-weight: bold; font-size: 16px; margin-bottom: 8px; color: #2c3e50;">${outlet.nama}</div>
            ${fotoContent}
            ${distanceInfo}
            <div class="popup-info" style="margin: 5px 0; display: flex; align-items: center;">
                <i class="fas fa-tag" style="width: 20px; color: #27ae60; margin-right: 8px;"></i>
                <span>${outlet.kategori.charAt(0).toUpperCase() + outlet.kategori.slice(1)}</span>
                <span class="halal-badge" style="background: #27ae60; color: white; padding: 2px 6px; border-radius: 12px; font-size: 10px; margin-left: 8px;">✓ Halal ${outlet.sertifikat}</span>
            </div>
            ${outlet.idSertifikat ? `<div class="popup-info" style="margin: 5px 0; display: flex; align-items: center;"><i class="fas fa-id-card" style="width: 20px; color: #3498db; margin-right: 8px;"></i><span>ID: ${outlet.idSertifikat}</span></div>` : ''}
            ${berlakuText ? `<div class="popup-info" style="margin: 5px 0; display: flex; align-items: center;"><i class="fas fa-certificate" style="width: 20px; color: #27ae60; margin-right: 8px;"></i><span>Berlaku s/d: ${berlakuText}</span></div>` : ''}
            <div class="popup-info" style="margin: 5px 0; display: flex; align-items: center;"><i class="fas fa-map-marker-alt" style="width: 20px; color: #e74c3c; margin-right: 8px;"></i><span>${outlet.alamat}</span></div>
            ${outlet.telepon && outlet.telepon !== 'Tidak tersedia' ? `<div class="popup-info" style="margin: 5px 0; display: flex; align-items: center;"><i class="fas fa-phone" style="width: 20px; color: #3498db; margin-right: 8px;"></i><span>${outlet.telepon}</span></div>` : ''}
            ${outlet.jamBuka && outlet.jamBuka !== 'Tidak tersedia' ? `<div class="popup-info" style="margin: 5px 0; display: flex; align-items: center;"><i class="fas fa-clock" style="width: 20px; color: #f39c12; margin-right: 8px;"></i><span>${outlet.jamBuka}</span></div>` : ''}
            ${outlet.rating > 0 ? `<div class="popup-info" style="margin: 5px 0; display: flex; align-items: center;"><i class="fas fa-star" style="width: 20px; color: #f1c40f; margin-right: 8px;"></i><span>Rating: ${outlet.rating}/5</span></div>` : ''}
            ${outlet.map ? `<div class="popup-info" style="margin: 5px 0; display: flex; align-items: center;"><i class="fas fa-external-link-alt" style="width: 20px; color: #9b59b6; margin-right: 8px;"></i><a href="${outlet.map}" target="_blank" style="color: #9b59b6; text-decoration: none;">Lihat di Maps</a></div>` : ''}
        </div>`;
        }

        function addMarkers(data) {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
            const validData = data.filter(o => o.lat && o.lng && !isNaN(o.lat) && !isNaN(o.lng));
            if (validData.length > 0) {
                validData.forEach(outlet => {
                    const marker = L.marker([outlet.lat, outlet.lng])
                        .bindPopup(createPopupContent(outlet))
                        .addTo(map);
                    markers.push(marker);
                });
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        }

        function updateOutletList(data) {
            const container = document.getElementById('outlet-items');
            if (!container) return;
            container.innerHTML = '';
            if (data.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: #666; padding: 2rem;">Tidak ada kuliner yang ditemukan</p>';
                return;
            }

            data.forEach(outlet => {
                const item = document.createElement('div');
                item.className = 'outlet-item';
                item.style.cssText = `
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            gap: 15px;
        `;

                // Foto outlet dengan ukuran yang sama
                const fotoContent = outlet.foto ? `
            <div class="outlet-foto" style="flex-shrink: 0;">
                <img src="${outlet.foto}" alt="${outlet.nama}" 
                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #ddd;"
                     onerror="this.style.display='none'; this.parentElement.style.display='none';">
            </div>` : '';

                // Info jarak
                const distanceInfo = outlet.distance ? `
            <div class="outlet-info" style="margin: 3px 0; color: #c0392b; font-weight: bold; font-size: 14px;">
                <i class="fas fa-route" style="margin-right: 8px;"></i>
                <span>Jarak: ${parseFloat(outlet.distance).toFixed(2)} km</span>
            </div>` : '';

                // Rating stars
                const ratingStars = outlet.rating > 0 ?
                    '★'.repeat(Math.floor(outlet.rating)) + '☆'.repeat(5 - Math.floor(outlet.rating)) : '';

                item.innerHTML = `
            ${fotoContent}
            <div class="outlet-details" style="flex: 1;">
                <div class="outlet-name" style="font-weight: bold; font-size: 18px; color: #2c3e50; margin-bottom: 8px;">${outlet.nama}</div>
                
                <div class="outlet-meta" style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 8px;">
                    <div class="outlet-info" style="display: flex; align-items: center; color: #555; font-size: 14px;">
                        <i class="fas fa-map-marker-alt" style="color: #e74c3c; margin-right: 6px;"></i>
                        <span>${outlet.kecamatan.charAt(0).toUpperCase() + outlet.kecamatan.slice(1).replace(/-/g, ' ')}</span>
                    </div>
                    
                    <div class="outlet-info" style="display: flex; align-items: center; color: #555; font-size: 14px;">
                        <i class="fas fa-tag" style="color: #27ae60; margin-right: 6px;"></i>
                        <span>${outlet.kategori.charAt(0).toUpperCase() + outlet.kategori.slice(1)}</span>
                    </div>
                    
                    ${outlet.rating > 0 ? `
                    <div class="outlet-info" style="display: flex; align-items: center; color: #555; font-size: 14px;">
                        <i class="fas fa-star" style="color: #f1c40f; margin-right: 6px;"></i>
                        <span>${outlet.rating}/5</span>
                        <span style="color: #f1c40f; margin-left: 4px;">${ratingStars}</span>
                    </div>` : ''}
                    
                    ${outlet.harga ? `
                    <div class="outlet-info" style="display: flex; align-items: center; color: #555; font-size: 14px;">
                        <i class="fas fa-money-bill-wave" style="color: #3498db; margin-right: 6px;"></i>
                        <span>${outlet.harga.charAt(0).toUpperCase() + outlet.harga.slice(1)}</span>
                    </div>` : ''}
                </div>
                
                ${distanceInfo}
                
                <div class="outlet-badges" style="display: flex; gap: 8px; margin-top: 8px;">
                    <span class="halal-badge" style="background: #27ae60; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                        ✓ Halal ${outlet.sertifikat}
                    </span>
                    ${outlet.jamBuka && outlet.jamBuka !== 'Tidak tersedia' ? `
                    <span class="jam-badge" style="background: #f39c12; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                        <i class="fas fa-clock"></i> ${outlet.jamBuka}
                    </span>` : ''}
                </div>
            </div>
        `;

                // Hover effect
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
                });

                item.addEventListener('click', () => {
                    if (outlet.lat && outlet.lng) {
                        map.setView([outlet.lat, outlet.lng], 16);
                        const marker = markers.find(m => m.getLatLng().lat === outlet.lat && m.getLatLng().lng === outlet.lng);
                        if (marker) marker.openPopup();
                    } else {
                        alert('Lokasi kuliner ini belum tersedia di peta');
                    }
                });

                container.appendChild(item);
            });
        }

        function filterData() {
            const kategori = document.getElementById('kategori')?.value.toLowerCase() || '';
            const kecamatan = document.getElementById('kecamatan')?.value.toLowerCase() || '';
            const harga = document.getElementById('harga')?.value.toLowerCase() || '';
            const pencarian = document.getElementById('pencarian')?.value.toLowerCase().trim() || '';

            filteredData = outletData.filter(outlet =>
                (!kategori || outlet.kategori.toLowerCase() === kategori) &&
                (!kecamatan || outlet.kecamatan.toLowerCase() === kecamatan) &&
                (!harga || outlet.harga.toLowerCase() === harga) &&
                (!pencarian || outlet.nama.toLowerCase().includes(pencarian))
            );
            addMarkers(filteredData);
            updateOutletList(filteredData);
            updateCounter(filteredData.length);
        }

        function resetFilters() {
            document.getElementById('kategori').value = '';
            document.getElementById('kecamatan').value = '';
            document.getElementById('harga').value = '';
            document.getElementById('pencarian').value = '';
            filterData();
        }

        async function refreshData() {
            await fetchOutletData();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // 1. Ambil data awal saat halaman dimuat
            fetchOutletData();

            // 2. Event listener untuk filter biasa
            let searchTimeout;
            document.getElementById('kategori').addEventListener('change', filterData);
            document.getElementById('kecamatan').addEventListener('change', filterData);
            document.getElementById('harga').addEventListener('change', filterData);
            document.getElementById('pencarian').addEventListener('input', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(filterData, 300);
            });

            // 3. Event listener untuk tombol "Cari Terdekat"
            const btnCariTerdekat = document.getElementById('btnCariTerdekat');
            if (btnCariTerdekat) {
                btnCariTerdekat.addEventListener('click', function() {
                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mencari...';

                    if (!navigator.geolocation) {
                        alert('Browser Anda tidak mendukung Geolocation.');
                        this.disabled = false;
                        this.innerHTML = '<i class="fas fa-map-marker-alt"></i> Gunakan Lokasi Saya';
                        return;
                    }

                    navigator.geolocation.getCurrentPosition(
                        async (position) => {
                                const {
                                    latitude,
                                    longitude
                                } = position.coords;

                                const baseUrl = window.location.origin;
                                const pathArray = window.location.pathname.split('/');
                                let projectPath = '';
                                if (pathArray.length > 2 && pathArray[1] !== 'index.php') {
                                    projectPath = '/' + pathArray[1];
                                }
                                const apiUrl = `${baseUrl}${projectPath}/api/find_nearby?lat=${latitude}&lon=${longitude}`;

                                try {
                                    const response = await fetch(apiUrl);
                                    const result = await response.json();

                                    if (result.success && result.data.length > 0) {
                                        resetFilters();
                                        const nearbyData = result.data.map(outlet => ({
                                            ...outlet,
                                            lat: parseFloat(outlet.latitude),
                                            lng: parseFloat(outlet.longitude)
                                        }));
                                        addMarkers(nearbyData);
                                        updateOutletList(nearbyData);
                                        updateCounter(nearbyData.length);
                                    } else {
                                        alert(result.message || 'Tidak ada outlet yang ditemukan di sekitar Anda.');
                                    }
                                } catch (error) {
                                    alert('Gagal mengambil data kuliner terdekat.');
                                } finally {
                                    btnCariTerdekat.disabled = false;
                                    btnCariTerdekat.innerHTML = '<i class="fas fa-map-marker-alt"></i> Gunakan Lokasi Saya';
                                }
                            },
                            (error) => {
                                alert(error.code === 1 ? 'Anda harus memberikan izin akses lokasi.' : 'Gagal mendapatkan lokasi.');
                                btnCariTerdekat.disabled = false;
                                btnCariTerdekat.innerHTML = '<i class="fas fa-map-marker-alt"></i> Gunakan Lokasi Saya';
                            }
                    );
                });
            }

            // 4. Smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        window.addEventListener('resize', function() {
            if (map) {
                setTimeout(() => map.invalidateSize(), 100);
            }
        });
    </script>

</body>

</html>