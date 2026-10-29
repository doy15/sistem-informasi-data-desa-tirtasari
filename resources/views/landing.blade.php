
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Tirtasari | Website Resmi</title>
    <meta name="description" content="Website resmi Desa Tirtasari untuk informasi profil, pelayanan, dan berita desa.">

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
    font-family: Arial, Helvetica, sans-serif;
    color: #1e293b;
    background: #ffffff;
    line-height: 1.6;
}

a {
    text-decoration: none;
    color: inherit;
}

.container {
    width: min(1120px, 90%);
    margin: auto;
}

/* NAVBAR */
.navbar {
    min-height: 76px;
    display: flex;
    align-items: center;
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    position: sticky;
    top: 0;
    z-index: 10;
    box-shadow: 0 3px 14px rgba(15, 23, 42, 0.04);
}

.nav-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.brand {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 800;
    font-size: 18px;
    color: #172554;
}

.brand-icon {
    width: 44px;
    height: 44px;
    display: grid;
    place-items: center;
    background: #dbeafe;
    border-radius: 12px;
    font-size: 24px;
}

.brand small {
    display: block;
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 26px;
    font-size: 14px;
    font-weight: 600;
}

.nav-links a:not(.btn):hover {
    color: #b8860b;
}

/* BUTTON */
.btn {
    display: inline-block;
    padding: 12px 20px;
    border-radius: 9px;
    background: #172554;
    color: #ffffff;
    font-size: 14px;
    font-weight: 700;
    border: 1px solid #172554;
    transition: 0.2s ease;
}

.btn:hover {
    background: #243b75;
    border-color: #243b75;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(23, 37, 84, 0.18);
}

/* HERO */
.hero {
    position: relative;
    min-height: 570px;
    display: flex;
    align-items: center;
    overflow: hidden;
    color: #ffffff;
    background:
        linear-gradient(
            90deg,
            rgba(15, 23, 42, 0.95),
            rgba(23, 37, 84, 0.78)
        ),
        url('/images/desa-tirtasari.jpg') center/cover,
        #172554;
}

.hero-content {
    max-width: 720px;
    padding: 90px 0;
}

.eyebrow {
    display: inline-block;
    padding: 8px 13px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.08);
    border-radius: 30px;
    font-size: 12px;
    letter-spacing: 1px;
    margin-bottom: 22px;
}

.hero h1 {
    font-size: clamp(36px, 5vw, 58px);
    line-height: 1.15;
    margin-bottom: 22px;
    letter-spacing: -1.5px;
}

.hero h1 span {
    color: #facc15;
}

.hero p {
    max-width: 590px;
    font-size: 17px;
    line-height: 1.9;
    color: #e2e8f0;
    margin-bottom: 30px;
}

.hero-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.hero-actions .btn {
    background: #facc15;
    color: #172554;
    border-color: #facc15;
}

.hero-actions .btn:hover {
    background: #eab308;
    border-color: #eab308;
}

.btn-light {
    display: inline-block;
    padding: 12px 20px;
    border-radius: 9px;
    border: 1px solid rgba(255, 255, 255, 0.65);
    color: #ffffff;
    font-size: 14px;
    font-weight: 700;
    transition: 0.2s ease;
}

.btn-light:hover {
    background: rgba(255, 255, 255, 0.12);
}

/* SECTION UMUM */
section {
    padding: 85px 0;
}

.section-label {
    color: #b8860b;
    text-transform: uppercase;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 2px;
    margin-bottom: 12px;
}

.section-title {
    font-size: clamp(28px, 4vw, 38px);
    line-height: 1.25;
    color: #172554;
    margin-bottom: 18px;
}

/* PROFIL DESA */
.about-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 55px;
    align-items: center;
}

.about-visual {
    min-height: 340px;
    border-radius: 20px;
    background:
        linear-gradient(
            0deg,
            rgba(23, 37, 84, 0.25),
            rgba(23, 37, 84, 0.04)
        ),
        url('/images/profil-desa.jpg') center/cover,
        #dbeafe;
    display: flex;
    align-items: end;
    padding: 24px;
}

.visual-caption {
    background: #ffffff;
    padding: 16px 20px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(15, 23, 42, 0.1);
    font-weight: 700;
    color: #172554;
}

.about-text {
    color: #64748b;
    margin-bottom: 24px;
    line-height: 1.9;
}

.text-link {
    color: #243b75;
    font-weight: 700;
    font-size: 14px;
}

.text-link:hover {
    color: #b8860b;
}

/* LAYANAN */
.services {
    background: #f1f5f9;
}

.section-heading {
    max-width: 650px;
    margin-bottom: 36px;
}

.service-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}

.service-card {
    padding: 28px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    transition: 0.2s ease;
}

.service-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
    border-color: #cbd5e1;
}

.service-icon {
    width: 52px;
    height: 52px;
    display: grid;
    place-items: center;
    background: #dbeafe;
    border-radius: 13px;
    font-size: 25px;
    margin-bottom: 20px;
}

.service-card h3 {
    margin-bottom: 10px;
    font-size: 18px;
    color: #172554;
}

.service-card p {
    color: #64748b;
    font-size: 14px;
    line-height: 1.8;
    margin-bottom: 18px;
}

/* CTA */
.cta {
    background: #172554;
    color: #ffffff;
    text-align: center;
    padding: 65px 20px;
}

.cta h2 {
    font-size: clamp(26px, 4vw, 36px);
    margin-bottom: 14px;
}

.cta p {
    color: #cbd5e1;
    margin-bottom: 25px;
}

.cta .btn {
    background: #facc15;
    color: #172554;
    border-color: #facc15;
}

.cta .btn:hover {
    background: #eab308;
    border-color: #eab308;
}

/* FOOTER */
footer {
    background: #0f172a;
    color: #cbd5e1;
    padding: 28px 0;
    font-size: 13px;
}

.footer-inner {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}

/* RESPONSIVE */
@media (max-width: 760px) {
    .navbar {
        height: auto;
        padding: 14px 0;
    }

    .nav-inner {
        align-items: flex-start;
    }

    .nav-links {
        gap: 12px;
        flex-wrap: wrap;
        justify-content: flex-end;
        font-size: 12px;
    }

    .nav-links .nav-about {
        display: none;
    }

    .brand {
        font-size: 15px;
    }

    .brand-icon {
        width: 38px;
        height: 38px;
    }

    .hero {
        min-height: 510px;
    }

    .hero p {
        font-size: 15px;
    }

    section {
        padding: 60px 0;
    }

    .about-grid,
    .service-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .about-visual {
        min-height: 250px;
    }
}

    </style>
</head>

<body>

    <header class="navbar">
        <div class="container nav-inner">
            <a href="{{ route('home') }}" class="brand">
                <div class="brand-icon">🌿</div>
                <div>
                    DESA TIRTASARI
                    <small>Website Resmi Desa</small>
                </div>
            </a>

            <nav class="nav-links">
                <a href="#beranda">Beranda</a>
                <a href="#profil" class="nav-about">Profil</a>
                <a href="#layanan">Layanan</a>
                <a href="{{ url('/login') }}" class="btn">Login Admin →</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero" id="beranda">
            <div class="container">
                <div class="hero-content">
                    <div class="eyebrow">SELAMAT DATANG DI WEBSITE RESMI</div>

                    <h1>
                        Membangun Desa,<br>
                        <span>Memajukan Bersama.</span>
                    </h1>

                    <p>
                        Selamat datang di website resmi Desa Tirtasari.
                        Temukan informasi desa, kenali potensi wilayah,
                        dan dapatkan informasi pelayanan dalam satu tempat.
                    </p>

                    <div class="hero-actions">
                        <a href="#profil" class="btn">Kenali Desa Kami →</a>
                        <a href="#layanan" class="btn-light">Jelajahi Layanan</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="profil">
            <div class="container about-grid">
                <div class="about-visual">
                    <div class="visual-caption">
                        🌱 Bersama Membangun Desa Tirtasari
                    </div>
                </div>

                <div>
                    <div class="section-label">Tentang Kami</div>
                    <h2 class="section-title">
                        Mengenal Lebih Dekat Desa Tirtasari
                    </h2>

                    <p class="about-text">
                        Desa Tirtasari berkomitmen untuk menghadirkan
                        pelayanan yang informatif, transparan, dan mudah
                        diakses oleh masyarakat. Website ini menjadi salah
                        satu sarana untuk mengenal profil desa dan memperoleh
                        informasi resmi.
                    </p>

                    <a href="#layanan" class="text-link">
                        Jelajahi informasi desa →
                    </a>
                </div>
            </div>
        </section>

        <section class="services" id="layanan">
            <div class="container">
                <div class="section-heading">
                    <div class="section-label">Informasi Desa</div>
                    <h2 class="section-title">
                        Informasi untuk Masyarakat
                    </h2>
                    <p class="about-text">
                        Akses informasi umum dan kenali layanan yang tersedia
                        melalui website resmi Desa Tirtasari.
                    </p>
                </div>

                <div class="service-grid">
                    <article class="service-card">
                        <div class="service-icon">🏡</div>
                        <h3>Profil Desa</h3>
                        <p>
                            Informasi umum mengenai desa dan gambaran
                            wilayah Desa Tirtasari.
                        </p>
                        <a href="#profil" class="text-link">Lihat profil →</a>
                    </article>

                    <article class="service-card">
                        <div class="service-icon">📋</div>
                        <h3>Informasi Pelayanan</h3>
                        <p>
                            Kenali informasi pelayanan administrasi
                            yang dapat ditanyakan kepada pemerintah desa.
                        </p>
                        <a href="{{ route('login') }}" class="text-link">
                            Masuk ke sistem →
                        </a>
                    </article>

                    <article class="service-card">
                        <div class="service-icon">📢</div>
                        <h3>Informasi Desa</h3>
                        <p>
                            Ikuti informasi dan pengumuman resmi
                            yang diterbitkan oleh pemerintah desa.
                        </p>
                        <a href="#kontak" class="text-link">
                            Informasi lebih lanjut →
                        </a>
                    </article>
                </div>
            </div>
        </section>

        <section class="cta" id="kontak">
            <div class="container">
                <h2>Desa Terbuka, Masyarakat Sejahtera</h2>
                <p>
                    Bersama mewujudkan Desa Tirtasari yang informatif
                    dan memberikan pelayanan terbaik.
                </p>
                <a href="{{ route('login') }}" class="btn">
                    Login ke Sistem Admin →
                </a>
            </div>
        </section>
    </main>

    <footer>
        <div class="container footer-inner">
            <span>© {{ date('Y') }} Pemerintah Desa Tirtasari.</span>
            <span>Website Resmi Desa Tirtasari</span>
        </div>
    </footer>

</body>
</html>
