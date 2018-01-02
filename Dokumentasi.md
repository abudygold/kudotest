Deskripsi:
	Aplikasi ini dikembangkan dengan Framework Codeigniter 3, dengan modul login ion_auth. Serta template yang digunakan adalah AdminLTE karena versi gratisnya lebih lengkap.

Database (kudotest):
	akses
		akses ini adalah tabel menu.
	grup
		grup ini adalah tabel kategori grup.
	grup_pengguna
		grup_pengguna ini adalah tabel relasi antara tabel pengguna dan tabel grup.
	konfigurasi
		konfigurasi ini adalah tabel menampung semua konfigurasi yang digunakan.
	login_attempts
		login_attempts ini adalah tabel ketika gagal login.
	pengguna
		pengguna ini adalah tabel user.

Level User:
	Admin (email : admin@admin.com - sandi: password)
	Member (email : user@test.com & test@user.com - sandi: password)

Menu:
	Dashboard
		Halaman awal ketika berhasil login, berisi dokumentasi program.
	Menus & Roles
		Menus
			digunakan untuk memanage menu secara dinamis.
		Roles
			digunakan untuk mengatur hak akses berdasarkan grup.
	Users
		digunakan untuk mengatur user (edit, active, deactivate, delete).
	Groups
		digunakan untuk mengatur level grup (CRUD).
	Profile
		digunakan untuk update profile dan ganti password.
	Configurations
		digunakan untuk konfigurasi website (general setting, seo, social media, contact).

