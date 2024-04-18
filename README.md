# Website Pondok Mbodo

Website Sistem Informasi Yayasan Pondok Pesantren Ki Ageng Mbodo, digunakan untuk administrasi yang ada diYayasan.

## Fitur

### Modul Publik dan Informasi

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

-   [ ] Administrasi Santri `StudentProduct`
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
