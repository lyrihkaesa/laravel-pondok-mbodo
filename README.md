# Website Pondok Mbodo

Website Sistem Informasi Yayasan Pondok Pesantren Ki Ageng Mbodo, digunakan untuk administrasi yang ada diYayasan.

## Fitur

### Modul Informasi Publik

-   [ ] Home/Beranda/Landing Page `/`
-   [ ] About/Profile Page `/tentang`
-   [ ] Badan Lembaga List `/lembaga`
-   [ ] Badan Lembaga Detail `/lembaga/{slug}` - `Organization`
-   [ ] Ekstrakurikuler `/ekstra`
-   [ ] Ekstrakurikuler Detail `/ekstra/{slug}` - `Extracurricular`
-   [ ] Fasilitas List `/fasilitas`
-   [ ] Fasilitas Detail `/fasilitas/{slug}` - `Facility`
-   [ ] Program List `/program`
-   [ ] Program Detail `/program/{slug}` - `Program`
-   [ ] Pawarto `/pawarto`
-   [ ] Pawarto Detail `/pawarto/{slug}` - `Blog`

### Modul PPDB

-   [ ] PPDB Page `/ppdb`
-   [ ] Biaya Pendidikan Page `/ppdb/biaya`
-   [ ] Edit PPDB Page `/admin/pages/{id}`
-   [ ] PPDB/Formulir Page (Pendaftaran Calon Santri) `/ppdb/formulir`
    -   [ ] Create Santri Reguler
    -   [ ] Create Santri Ndalem
    -   [ ] Create Santri Berprestasi

### Modul User

-   [ ] Create User
-   [ ] Read User
-   [ ] Update User
-   [ ] Delete User
    -   [ ] Soft Delete
-   [ ] Berelasi One to One Santri `Student`
-   [ ] Berelasi One to One Pengurus `Employee`
-   [ ] Berelasi One to One Jemaah `Customer`
-   [ ] Berelasi One To Many Peran `Role`
-   [ ] Berelasi One To Many Ijin `Premission`

### Modul Peran dan Ijin

`Role` dan `Premission`

-   [ ] Use Laravel Spatie Role Premission

### Modul Santri

`Student`

-   [ ] Create Santri
-   [ ] Read Santri
-   [ ] Update Santri
-   [ ] Delete Santri
    -   [ ] Soft Delete

### Modul Pengurus

`Employee`

-   [ ] Create Pengurus
-   [ ] Read Pengurus
-   [ ] Update Pengurus
-   [ ] Delete Pengurus
    -   [ ] Soft Delete

### Modul Administrasi

-   [ ] Administrasi Santri `StudentBill`
-   [ ] Jenis Biaya `Product`
-   [ ] Paket `Package`
-   [ ] Transaksi `Transaction`
-   [ ] Administrasi Langit Tour `LangitTourProduct`

### Modul Orang Tua/Wali

`Guardian`

-   [ ] Login sebagai `Orang Tua/Wali` dengan menggunakan `Nomor Telepon (Whatsapp)` dan `Nomor KK`
-   [ ] Melihat santri yang diwalikan

### Modul Alumni

-   [ ] Edit Profile

### Modul Langit Tour

-   [ ] Create Jemaah

### Modul Donatur

-   [ ] Create Donatur

---

## Menggunakan Docker

Pertama clone project

```bash
git clone -b dev https://github.com/lyrihkaesa/laravel-pondok-mbodo.git pondokmbodo
```

Pindah ke directori project pondokmbodo:

```bash
cd pondokmbodo
```

Copy file Env

```bash
cp .env.example .env
```

Key Generate

```bash
php artisan key:generate
```

Saya menggunakan PostgreSQL jadi pastikan ada PostgreSQL dan ubah pada envnya

```env
DB_CONNECTION=pgsql # default: mysql
DB_HOST=192.168.x.x
DB_PORT=5432 # default: 3306
DB_DATABASE=laravel_pondok_mbodo
DB_USERNAME=postgres # default: root
DB_PASSWORD=postgres
```

Saya juga menggunakan minio, jika tidak ingin menggunakan minio ubah menjadi defaultnya.
Default nilai env tanpa minio:

```env
FILESYSTEM_DISK=local
FILAMENT_FILESYSTEM_DISK=public
```

Jika anda menggunakan minio, buat dulu bucket misal `pondokmbodo` dan `pondokmbodo_public`, dan buat juga `MINIO_ACCESS_KEY_ID` dan `MINIO_SECRET_ACCESS_KEY` yang nantinya aka dimasukan ke dalam env berikut:

```env
FILESYSTEM_DISK=minio # default: local
# [Opsional] Konfigurasi default filesystems package filament
FILAMENT_FILESYSTEM_DISK=minio_public #default: public

# Konfigurasi untuk bucket MinIO privat
MINIO_ACCESS_KEY_ID=
MINIO_SECRET_ACCESS_KEY=
MINIO_DEFAULT_REGION=id-jkt-1-default # random
MINIO_BUCKET=pondokmbodo
# MINIO_URL=
MINIO_ENDPOINT=http://your-ip-address:9010 # default port: 9000
MINIO_USE_PATH_STYLE_ENDPOINT=true
MINIO_USE_SSL=false
# MINIO_THROW=true

# Konfigurasi untuk bucket MinIO publik
# MINIO_PUBLIC_ACCESS_KEY_ID=
# MINIO_PUBLIC_SECRET_ACCESS_KEY=
# MINIO_PUBLIC_DEFAULT_REGION=id-jkt-1-default # random
MINIO_PUBLIC_BUCKET=pondokmbodo-public
# MINIO_PUBLIC_URL=
# MINIO_PUBLIC_ENDPOINT=http://your-ip-address:9000 # default port: 9000
# MINIO_PUBLIC_USE_PATH_STYLE_ENDPOINT=true
# MINIO_PUBLIC_USE_SSL=false
# MINIO_PUBLIC_THROW=true
```

Setelah itu jalankan perintah berikut:

```bash
docker compose up
```

Jika error storage permission ketik perintah ini

```bash
docker exec -it pondokmbodo-app-1 sh
```

Jika tidak bisa masuk ke terminal

```bash
docker exec -it pondokmbodo-app-1 bash
```

Ganti owner dari folder storage

```bash
chown -R www-data:www-data /var/www/html/storage/*
```

Jika ingin performa baik:

```bash
php artisan optimize:clear
```

```bash
php artisan optimize
```

Jangan lupa cache icons blade filament

```bash
php artisan icons:cache
```

Jika lupa build css dan js, error vite, jalankan perintah:

```bash
npm run build
```

### Build Image Docker

Jika ingin build ulang

```bash
docker compose build
```

### Menjalankan Docker Compose

```bash
docker compose up
```

Jika ingin menjalankan compose dengan nama lain

```bash
docker compose -p pondokmbodo up -d
```

### Menghentikan Docker Compose

```bash
docker compose down
```

Jika sebelumnya menjalankan docker compose dengan nama lain, maka perlu nama lain tersebut untuk menghentikannya

```bash
docker compose -p pondokmbodo down
```
