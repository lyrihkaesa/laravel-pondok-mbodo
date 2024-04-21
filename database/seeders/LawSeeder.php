<?php

namespace Database\Seeders;

use App\Models\Law;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laws = [
            [
                'chapter' => 1,
                'chapter_title' => 'PERATURAN UMUM',
                'section' => [
                    [
                        'section' => 1,
                        'section_title' => 'KEWAJIBAN',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "Wajib taat kepada ketentuan allah dan rasul yang termaktub dalam al-qur'an,al-hadist dan kutubul mu'tabaroh.",
                                'point' => 2,
                            ],
                            [
                                'article' => 2,
                                'content' => "Wajib mengikuti kegiatan pesantren, formal, jurusan, ekstrakulikuler, dan pelatihan.",
                                'point' => 2,
                            ],
                            [
                                'article' => 3,
                                'content' => "Wajib berperilaku sopan dalam perbuatan dan perkataan di lingkungan pesantren, sekitar pesantren/ masyarakat, dan di waktu sambang.",
                                'point' => 2,
                            ],
                            [
                                'article' => 4,
                                'content' => "Wajib memakai seragam yang telah ditentukan, atau baju lengan panjang saat kegiatan.",
                                'point' => 1,
                            ],
                            [
                                'article' => 5,
                                'content' => "Wajib menjaga kebersihan, keamanan, ketertiban, keindahan, dan kekeluargaan di lingkungan pesantren, sekolah, maupun madrasah.",
                                'point' => 1,
                            ],
                            [
                                'article' => 6,
                                'content' => "Wajib membayar administrasi, syahriyah sesuai ketentuan yang berlaku.",
                                'point' => 2,
                            ],
                            [
                                'article' => 7,
                                'content' => "Wajib menempuh rute jalan berangkat dan pulang kegiatan sesuai ketentuan yang berlaku.",
                                'point' => 1,
                            ],
                            [
                                'article' => 8,
                                'content' => "Wajib berpakaian Syar'i Wa'Adatan saat di pesantren, diluar pesantren, maupun di rumah.",
                                'point' => 2,
                            ],
                            [
                                'article' => 9,
                                'content' => "Wajib memiliki peralatan perlengkapan pokok dan tambahan sesuai ketentuan yang berlaku.",
                                'point' => 1,
                            ],
                            [
                                'article' => 10,
                                'content' => "Wajib memiliki kartu tanda santri.",
                                'point' => 1,
                            ],
                        ]
                    ],
                    [
                        'section' => 2,
                        'section_title' => 'LARANGAN',
                        'article' => [
                            [
                                'article' => 11,
                                'content' => "Dilarang pacaran dalam bentuk apapun baik Murosalah, Kholwah, maupun komunikasi yang melanggar Syara'.",
                                'point' => 10,
                            ],
                            [
                                'article' => 12,
                                'content' => "Dilarang minum minuman keras, berjudi, narkoba, dan sejenisnya menyimpan atau mengedarkannya.",
                                'point' => 10,
                            ],
                            [
                                'article' => 13,
                                'content' => "Dilarang bermain kartu dan sejenisnya atau menyimpannya.",
                                'point' => 5,
                            ],
                            [
                                'article' => 14,
                                'content' => "Dilarang memiliki, menyimpan, melihat, dan membaca atau mengedarkan gambar porno menurut pandangan pesantren.",
                                'point' => 10,
                            ],
                            [
                                'article' => 15,
                                'content' => "Dilarang memiliki, menyimpan, dan memperjualbelikan SAJAM (Senjata Tajam).",
                                'point' => 1,
                            ],
                            [
                                'article' => 16,
                                'content' => "Dilarang membully dan berkata kotor.",
                                'point' => 2,
                            ],
                            [
                                'article' => 17,
                                'content' => "Dilarang antar Santri Putra dan Putri mengobrol di Taman Suwuk, jalanan, area pesantren yang bertentangan dengan etika pesantren.",
                                'point' => 5,
                            ],
                            [
                                'article' => 18,
                                'content' => "Dilarang keluyuran diluar pesantren kecuali kegiatan dan tugas dari pesantren.",
                                'point' => 5,
                            ],
                            [
                                'article' => 19,
                                'content' => "Dilarang membawa, meminjam, menggunakan sepeda ontel dan sepeda motor kecuali mendapat izin keamanan dan tugas pesantren.",
                                'point' => 3,
                            ],
                            [
                                'article' => 20,
                                'content' => "Dilarang membunyikan atau menyimpan alat-alat musik, barang elektronik kecuali perangkat pembelajaran.",
                                'point' => 2,
                            ],
                            [
                                'article' => 21,
                                'content' => "Dilarang menggunakan, menyimpan laptop, dan handphone, kecuali mendapatkan izin atau untuk perangkat pembelajaran.",
                                'point' => 10,
                            ],
                            [
                                'article' => 22,
                                'content' => "Dilarang menerima tamu kecuali mendapat izin keamanan dan pertemuan berlangsung di Taman Suwuk.",
                                'point' => 3,
                            ],
                            [
                                'article' => 23,
                                'content' => "Dilarang nongkrong di lingkungan pesantren dan formal kecuali untuk nderes.",
                                'point' => 2,
                            ],
                            [
                                'article' => 24,
                                'content' => "Dilarang bertengkar dan berkelahi.",
                                'point' => 10,
                            ],
                            [
                                'article' => 25,
                                'content' => "Dilarang memanggil nama teman dengan panggilan jangkar.",
                                'point' => 2,
                            ],
                            [
                                'article' => 26,
                                'content' => "Dilarang memasang, merobek, merusak brosur, pamphlet, pengumuman pada papan pengumuman, mading kecuali mendapat izin pengurus.",
                                'point' => 2,
                            ],
                            [
                                'article' => 27,
                                'content' => "Dilarang memindahkan, merusak instalasi listrik dan internet.",
                                'point' => 5,
                            ],
                            [
                                'article' => 28,
                                'content' => "Dilarang potong rambut dengan gaya yang tidak sopan. Standar kesopanan potongan rambut adalah gaya rapi.",
                                'point' => 5,
                            ],
                            [
                                'article' => 29,
                                'content' => "Dilarang memakai aksesoris, gelang, kalung yang melanggar etika pesantren dan syara'.",
                                'point' => 2,
                            ],
                            [
                                'article' => 30,
                                'content' => "Dilarang bertato dan menyemir rambut yang melanggar etika pesantren.",
                                'point' => 5,
                            ],
                            [
                                'article' => 31,
                                'content' => "Dilarang memakai kaos kecuali saat di Asrama.",
                                'point' => 3,
                            ],
                            [
                                'article' => 32,
                                'content' => "Dilarang bersolek berlebihan.",
                                'point' => 2,
                            ],
                            [
                                'article' => 33,
                                'content' => "Dilarang makan dan minum sambil berjalan.",
                                'point' => 2,
                            ],
                            [
                                'article' => 34,
                                'content' => "Dilarang begadang.",
                                'point' => 1,
                            ],
                            [
                                'article' => 35,
                                'content' => "Dilarang pinjam meminjam peralatan Santri Putra ke Santri Putri maupun sebaliknya tanpa izin Keamanan.",
                                'point' => 3,
                            ],
                            [
                                'article' => 36,
                                'content' => "Dilarang membawa uang cash.",
                                'point' => 10,
                            ],
                            [
                                'article' => 37,
                                'content' => "Dilarang membuat Gank.",
                                'point' => 10,
                            ],
                            [
                                'article' => 38,
                                'content' => "Dilarang membawa dan membaca novel yang tidak mendidik.",
                                'point' => 10,
                            ],
                            [
                                'article' => 39,
                                'content' => "Dilarang merokok sampai batas umur 18 tahun.",
                                'point' => 10,
                            ],
                            [
                                'article' => 40,
                                'content' => "Dilarang gundulan (Tanpa membawa penutup kepala) di area pesantren.",
                                'point' => 3,
                            ],
                            [
                                'article' => 41,
                                'content' => "Dilarang meminjam peralatan milik masyarakat kampung kecuali mendapat izin pengasuh.",
                                'point' => 5,
                            ],
                            [
                                'article' => 42,
                                'content' => "Dilarang menggunakan peralatan BUMP kecuali mendapat izin.",
                                'point' => 3,
                            ],
                        ]
                    ],
                ],
            ],

            // BAB II
            [
                'chapter' => 2,
                'chapter_title' => 'NDALEM',
                'section' => [
                    [
                        'section' => 3,
                        'section_title' => 'KEWAJIBAN',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "Santri wajib sendika dawuh kepada pengasuh dan ahlul bait.",
                                'point' => 10,
                            ],
                            [
                                'article' => 2,
                                'content' => "Santri wajib mematuhi perintah ndalem melalui abdi ndalem.",
                                'point' => 5,
                            ],
                            [
                                'article' => 3,
                                'content' => "Santri wajib mematuhi piket kebersihan ndalem dan sekitar ndalem.",
                                'point' => 2,
                            ],
                            [
                                'article' => 4,
                                'content' => "Santri wajib mematuhi piket jaga ndalem.",
                                'point' => 2,
                            ],
                            [
                                'article' => 5,
                                'content' => "Wajib ikut dalam merawat peralatan ndalem.",
                                'point' => 2,
                            ],
                            [
                                'article' => 6,
                                'content' => "Wajib bersikap ramah,menghormati dan mengerjakan hal baik kepada Gus dan Neng.",
                                'point' => 5,
                            ],
                            [
                                'article' => 7,
                                'content' => "Wajib menjaga nama baik dan kehormatan pengasuh dan keluarga ndalem.",
                                'point' => 5,
                            ],
                        ]
                    ],
                ],
            ],

            // BAB III
            [
                'chapter' => 3,
                'chapter_title' => 'FORMAL',
                'section' => [
                    [
                        'section' => 4,
                        'section_title' => 'KEWAJIBAN',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "Wajib taat pada kepala sekolah dan jajaran dewan guru.",
                                'point' => 3,
                            ],
                            [
                                'article' => 2,
                                'content' => "Wajib mengikuti apel pagi.",
                                'point' => 1,
                            ],
                            [
                                'article' => 3,
                                'content' => "Wajib mengikuti lalaran.",
                                'point' => 1,
                            ],
                            [
                                'article' => 4,
                                'content' => "Wajib berseragam sesuai ketentuan yang berlaku.",
                                'point' => 1,
                            ],
                            [
                                'article' => 5,
                                'content' => "Wajib izin secara tertulis jika tidak dapat mengikuti pembelajaran.",
                                'point' => 2,
                            ],
                            [
                                'article' => 6,
                                'content' => "Wajib menjaga kebersihan keamanan dan ketertiban di lingkungan sekolah.",
                                'point' => 1,
                            ],
                            [
                                'article' => 7,
                                'content' => "Wajib berperilaku dan berkomunikasi dengan baik dan sopan.",
                                'point' => 2,
                            ],
                            [
                                'article' => 8,
                                'content' => "Wajib membawa perlengkapan belajar.",
                                'point' => 1,
                            ],
                            [
                                'article' => 9,
                                'content' => "Wajib mengikuti kegiatan keorganisasian.",
                                'point' => 1,
                            ],
                            [
                                'article' => 10,
                                'content' => "Wajib menjaga fasilitas sekolah.",
                                'point' => 2,
                            ],
                            [
                                'article' => 11,
                                'content' => "Wajib mengikuti salat Dhuha dan salat dzuhur berjamaah.",
                                'point' => 1,
                            ],
                            [
                                'article' => 12,
                                'content' => "Wajib berdiri saat guru awal masuk kelas.",
                                'point' => 1,
                            ],
                        ]
                    ],
                    [
                        'section' => 5,
                        'section_title' => 'LARANGAN',
                        'article' => [
                            [
                                'article' => 13,
                                'content' => "Dilarang makan dan menyimpan makanan di dalam kelas.",
                                'point' => 1,
                            ],
                            [
                                'article' => 14,
                                'content' => "Dilarang mencoret-coret fasilitas sekolah dan ruang kelas.",
                                'point' => 3,
                            ],
                            [
                                'article' => 15,
                                'content' => "Dilarang merusak tanaman di lingkungan sekolah.",
                                'point' => 2,
                            ],
                            [
                                'article' => 16,
                                'content' => "Dilarang bersenda gurau antara laki-laki dan perempuan secara berlebihan.",
                                'point' => 5,
                            ],
                            [
                                'article' => 17,
                                'content' => "Dilarang menggunakan meja, kursi dan perabotan sekolah kecuali mendapat izin dari petugas sarpras.",
                                'point' => 2,
                            ],
                            [
                                'article' => 18,
                                'content' => "Dilarang membantah atau menimpali nasihat guru.",
                                'point' => 2,
                            ],
                            [
                                'article' => 19,
                                'content' => "Dilarang jajan saat pelajaran berlangsung.",
                                'point' => 1,
                            ],
                            [
                                'article' => 20,
                                'content' => "Dilarang meninggalkan peralatan dan perlengkapan di ruang kelas.",
                                'point' => 1,
                            ],
                        ]
                    ],
                ],
            ],

            // BAB IV
            [
                'chapter' => 4,
                'chapter_title' => 'ASRAMA',
                'section' => [
                    [
                        'section' => 6,
                        'section_title' => 'KEWAJIBAN',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "Wajib taat kepada kepala asrama, keamanan dan ketua kamar.",
                                'point' => 3,
                            ],
                            [
                                'article' => 2,
                                'content' => "Wajib mengikuti kegiatan asrama: salat berjamaah, belajar wajib, wirid harian,khitobah,ziarah makam.",
                                'point' => 2,
                            ],
                            [
                                'article' => 3,
                                'content' => "Wajib menjalankan piket asrama baik kebersihan.",
                                'point' => 2,
                            ],
                            [
                                'article' => 4,
                                'content' => "Wajib mematuhi jam malam maksimal pukul 22.00 WIB.",
                                'point' => 5,
                            ],
                            [
                                'article' => 5,
                                'content' => "Wajib berpakaian syar'an wa adatan.",
                                'point' => 2,
                            ],
                            [
                                'article' => 6,
                                'content' => "Wajib menjaga barang dan fasilitas asrama.",
                                'point' => 2,
                            ],
                            [
                                'article' => 7,
                                'content' => "Wajib memiliki peralatan perlengkapan mandi mencuci, tidur sesuai ketentuan yang berlaku.",
                                'point' => 2,
                            ],
                            [
                                'article' => 8,
                                'content' => "Wajib mematikan lampu dan keran yang tidak digunakan.",
                                'point' => 1,
                            ],
                        ]
                    ],
                    [
                        'section' => 7,
                        'section_title' => 'LARANGAN',
                        'article' => [
                            [
                                'article' => 9,
                                'content' => "Dilarang mencuri dan mengghosob.",
                                'point' => 3,
                            ],
                            [
                                'article' => 10,
                                'content' => "Dilarang membawa tamu masuk asrama.",
                                'point' => 5,
                            ],
                            [
                                'article' => 11,
                                'content' => "Dilarang begadang, maksimal terjaga pukul 00.00 WIB kecuali untuk belajar, wirid, riyadhoh,ada kegiatan dan tugas dari pesantren.",
                                'point' => 1,
                            ],
                            [
                                'article' => 12,
                                'content' => "Dilarang menjahili teman saat salat, tidur, mandi dan sebagainya.",
                                'point' => 2,
                            ],
                            [
                                'article' => 13,
                                'content' => "Dilarang masuk kamar lain tanpa izin ketua kamar.",
                                'point' => 1,
                            ],
                            [
                                'article' => 14,
                                'content' => "Dilarang membuang sampah sembarangan, meninggalkan sisa makanan dan peralatannya di kamar maupun area asrama.",
                                'point' => 1,
                            ],
                            [
                                'article' => 15,
                                'content' => "Dilarang membawa pakaian lebih dari ketentuan yang berlaku.",
                                'point' => 2,
                            ],
                            [
                                'article' => 16,
                                'content' => "Dilarang meninggalkan pakaian,peralatan dapur, peralatan mandi, peralatan belajar di sembarang tempat.",
                                'point' => 1,
                            ],
                            [
                                'article' => 17,
                                'content' => "Dilarang tidur di ruang kelas, taman dan di rumah warga.",
                                'point' => 2,
                            ],
                        ]
                    ],
                ],
            ],

            // BAB V
            [
                'chapter' => 5,
                'chapter_title' => 'ORGANISASI',
                'section' => [
                    [
                        'section' => 8,
                        'section_title' => 'PERATURAN ORGANISASI',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "Menjaga nama baik dan setia kepada organisasi",
                                'point' => 2,
                            ],
                            [
                                'article' => 2,
                                'content' => "Melaksanakan tugas yang diamanahkan dengan penuh pengabdian,kesadaran dan tanggung jawab.",
                                'point' => 2,
                            ],
                            [
                                'article' => 3,
                                'content' => "Mengutamakan kepentingan organisasi dari kepentingan pribadi.",
                                'point' => 2,
                            ],
                            [
                                'article' => 4,
                                'content' => "Bekerja jujur, tertib, cermat dan bersemangat dalam kepentingan organisasi.",
                                'point' => 2,
                            ],
                            [
                                'article' => 5,
                                'content' => "Melaporkan kepada atasan apabila ada hal yang merugikan bersama.",
                                'point' => 2,
                            ],
                            [
                                'article' => 6,
                                'content' => "Hadir tepat waktu saat rapat dan kegiatan organisasi.",
                                'point' => 2,
                            ],
                            [
                                'article' => 7,
                                'content' => "Dilarang membuat kegiatan di luar kesepakatan bersama.",
                                'point' => 2,
                            ],
                            [
                                'article' => 8,
                                'content' => "Dilarang menyalahgunakan jabatan untuk kepentingan pribadi.",
                                'point' => 2,
                            ],
                            [
                                'article' => 9,
                                'content' => "Wajib mengikuti kegiatan organisasi yang telah berlaku.",
                                'point' => 2,
                            ],
                            [
                                'article' => 10,
                                'content' => "Dilarang mengikuti organisasi di luar Pesantren kecuali mendapat izin pengasuh.",
                                'point' => 2,
                            ],
                        ]
                    ],
                ],
            ],

            // BAB VI
            [
                'chapter' => 6,
                'chapter_title' => 'JURUSAN',
                'section' => [
                    [
                        'section' => 9,
                        'section_title' => 'KEWAJIBAN',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "Wajib taat kepada kepala jurusan, guru jurusan, dan ketua himpunan santri jurusan.",
                                'point' => 3,
                            ],
                            [
                                'article' => 2,
                                'content' => "Wajib berseragam sesuai ketentuan yang berlaku.",
                                'point' => 1,
                            ],
                            [
                                'article' => 3,
                                'content' => "Wajib memiliki buku materi jurusan.",
                                'point' => 2,
                            ],
                            [
                                'article' => 4,
                                'content' => "Wajib berada di ruang kegiatan sebelum guru jurusan datang.",
                                'point' => 1,
                            ],
                            [
                                'article' => 5,
                                'content' => "Wajib belajar diruang jurusan saat guru berhalangan hadir.",
                                'point' => 2,
                            ],
                        ]
                    ],
                ],
            ],

            // BAB VII
            [
                'chapter' => 7,
                'chapter_title' => 'SANTRI KHIDMAH',
                'section' => [
                    [
                        'section' => 10,
                        'section_title' => 'PERATURAN SANTRI KHIDMAH',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "Wajib taat dan amanah dalam menjalankan tugas dari BUMP.",
                                'point' => 2,
                            ],
                            [
                                'article' => 2,
                                'content' => "Wajib menanda tangani MUU beserta walinya saat mengambil jalur khidmah.",
                                'point' => 2,
                            ],
                            [
                                'article' => 3,
                                'content' => "Wajib mengikuti pelatihan-pelatihan untuk menuju SOP dalam bidang tugas-tugasnya.",
                                'point' => 3,
                            ],
                            [
                                'article' => 4,
                                'content' => "Santri Reguler dilarang mengambil tugas Santri Khidmah kecuali mendapat izin dari yang bersangkutan.",
                                'point' => 2,
                            ],
                            [
                                'article' => 5,
                                'content' => "Wajib menjaga dan merawat inventaris BUMP.",
                                'point' => 3,
                            ],
                            [
                                'article' => 6,
                                'content' => "Santri Khidmah dilarang berkeluh kesah dan memviralkan kekurangan internal BUMP.",
                                'point' => 5,
                            ],
                        ]
                    ],
                ],
            ],

            // BAB VIII
            [
                'chapter' => 8,
                'chapter_title' => 'TIDAK MENGIKUTI KEGIATAN',
                'section' => [
                    [
                        'section' => 11,
                        'section_title' => 'PERIZINAN TIDAK MENGIKUTI KEGIATAN',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "	Izin diharuskan tertulis dan ditandatangani keamanan.",
                                'point' => 2,
                            ],
                            [
                                'article' => 2,
                                'content' => "Kegiatan luar, izin dibebankan kepada penanggung jawab secara tertulis.",
                                'point' => 2,
                            ],
                            [
                                'article' => 3,
                                'content' => "Ketentuan ini berlaku pada formal, jurusan, kegiatan asrama, dan pelatihan-pelatihan.",
                                'point' => 2,
                            ],
                        ]
                    ],
                ],
            ],

            // BAB IX
            [
                'chapter' => 9,
                'chapter_title' => 'PENJENGUKAN',
                'section' => [
                    [
                        'section' => 12,
                        'section_title' => 'PERATURAN PENJENGUKAN',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "Orang tua berpakaian sopan dan rapi.",
                                'point' => 2,
                            ],
                            [
                                'article' => 2,
                                'content' => "Sowan kepada pengasuh.",
                                'point' => 3,
                            ],
                            [
                                'article' => 3,
                                'content' => "Melapor kepada kepala asrama atau pengurus keamanan.",
                                'point' => 2,
                            ],
                            [
                                'article' => 4,
                                'content' => "Bertemu ditempat yang telah disediakan, Taman Suwuk.",
                                'point' => 5,
                            ],
                            [
                                'article' => 5,
                                'content' => "Wali santri dilarang masuk asrama.",
                                'point' => 5,
                            ],
                            [
                                'article' => 6,
                                'content' => "Wali santri dilarang membawa keluar santri kecuali mendapat izin dari keamanan",
                                'point' => 10,
                            ],
                            [
                                'article' => 7,
                                'content' => "Jadual penjengukan pada Minggu pertama dan terakhir setiap bulannya. Pukul 07.00 - 15.00 WIB.",
                                'point' => 5,
                            ],
                        ]
                    ],
                ],
            ],

            // BAB X
            [
                'chapter' => 10,
                'chapter_title' => 'SAMBANG DAN LIBURAN',
                'section' => [
                    [
                        'section' => 13,
                        'section_title' => 'PERATURAN SAMBANG DAN LIBURAN',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "Wajib dijemput mahram atau diantar pengurus keamanan.",
                                'point' => 2,
                            ],
                            [
                                'article' => 2,
                                'content' => "Wajib mematuhi batas sambang dan liburan yang ditetapkan.",
                                'point' => 10,
                            ],
                            [
                                'article' => 3,
                                'content' => "Wajib mendapat izin dari Kepala sekolah, kepala jurusan, kepala asrama, dan pengasuh.",
                                'point' => 10,
                            ],
                            [
                                'article' => 4,
                                'content' => "Wajib sowan kepada pengasuh ketika akan pulang dan datang ke pesantren.",
                                'point' => 2,
                            ],
                            [
                                'article' => 5,
                                'content' => "Wajib mengikuti kegiatan tambahan saat liburan.",
                                'point' => 10,
                            ],
                        ]
                    ],
                    [
                        'section' => 14,
                        'section_title' => 'PERATURAN PERIZINAN',
                        'article' => [
                            [
                                'article' => 6,
                                'content' => "Wajib berkoordinasi dengan kepala asrama atau pengurus keamanan via telepon.",
                                'point' => 2,
                            ],
                            [
                                'article' => 7,
                                'content' => "Maksimal sambang 3 hari",
                                'point' => 3,
                            ],
                            [
                                'article' => 8,
                                'content' => "Diperkenankan lebih dari 3 hari dengan ada udzur dan mendapat izin dari pengasuh.",
                                'point' => 2,
                            ],
                            [
                                'article' => 9,
                                'content' => "Ketentuan sambang bagi santri kurang dari 1 tahun adalah 2 bulan sekali. Sedangkan bagi santri yang diatas 1 tahun adalah 3 bulan sekali.",
                                'point' => 2,
                            ],
                        ]
                    ],
                ],
            ],

            // BAB XI
            [
                'chapter' => 11,
                'chapter_title' => 'MEDIA SOSIAL DAN ELEKTRONIK',
                'section' => [
                    [
                        'section' => 15,
                        'section_title' => 'KEWAJIBAN',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "Wajib memiliki surat izin membawa dan menggunakan laptop, HP, komputer, audio musik, dan sebagainya dari pengasuh.",
                                'point' => 10,
                            ],
                            [
                                'article' => 2,
                                'content' => "Santri wajib menyerahkan akun google : Email, WA, Instagram, Twitter, Youtube kepada pengasuh, kepala asrama, dan keamanan.",
                                'point' => 5,
                            ],
                            [
                                'article' => 3,
                                'content' => "Santri wajib mengikuti kegiatan-kegiatan yang dibentuk oleh pengasuh, BES, dan badan terkait.",
                                'point' => 5,
                            ],
                            [
                                'article' => 4,
                                'content' => "Wajib menyimpan laptop di kamar dan menggunakannya dalam pengawasan guru dan pengurus keamanan.",
                                'point' => 2,
                            ],
                        ]
                    ],
                    [
                        'section' => 16,
                        'section_title' => 'LARANGAN',
                        'article' => [
                            [
                                'article' => 5,
                                'content' => "Dilarang menyimpan game dan menggunakannya dalam bentuk offline maupun online.",
                                'point' => 3,
                            ],
                            [
                                'article' => 6,
                                'content' => "Dilarang menyimpan, upload, share foto, dan video di medsos yang dapat menimbulkan fitnah dan propaganda.",
                                'point' => 5,
                            ],
                            [
                                'article' => 7,
                                'content' => "Dilarang menggunakan, meminjam laptop dan HP bila tidak ada kepentingan dan tugas.",
                                'point' => 5,
                            ],
                            [
                                'article' => 8,
                                'content' => "Dilarang membuat status yang dapat mencemarkan nama baik santri dan martabat pesantren.",
                                'point' => 10,
                            ],
                            [
                                'article' => 9,
                                'content' => "Santri Putra dan Putri dilarang saling berkomentar di medsos yang dapat menimbulkan fitnah.",
                                'point' => 5,
                            ],
                        ]
                    ],
                ],
            ],

            // BAB XII
            [
                'chapter' => 12,
                'chapter_title' => 'POIN',
                'section' => [
                    [
                        'section' => 17,
                        'section_title' => 'KETENTUAN POIN',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "Informasi poin disandingkan dengan peraturan secara tertulis.",
                                'point' => 0,
                            ],
                            [
                                'article' => 2,
                                'content' => "Poin diberikan setelah melewati nasihat,kafaroh dan stakeholder keamanan.",
                                'point' => 0,
                            ],
                            [
                                'article' => 3,
                                'content' => "Yang berwenang memberi poin : Pengasuh,kepala asrama,kepala sekolah dan wali kelas.",
                                'point' => 0,
                            ],
                            [
                                'article' => 4,
                                'content' => "Keamanan bertugas memberi nasihat,mengkafarohi dan melaporkan pelanggaran kepada pengasuh.",
                                'point' => 0,
                            ],
                            [
                                'article' => 5,
                                'content' => "Keamanan tidak berwenang menerbitkan poin.",
                                'point' => 0,
                            ],
                        ]
                    ],
                    [
                        'section' => 18,
                        'section_title' => 'PEMBERIAN POIN',
                        'article' => [
                            [
                                'article' => 1,
                                'content' => "Melalui panggilan.",
                                'point' => 0,
                            ],
                            [
                                'article' => 2,
                                'content' => "Poin tertulis pada buku keamanan.",
                                'point' => 0,
                            ],
                            [
                                'article' => 3,
                                'content' => "Santri dengan poin tertinggi dipublikasikan.",
                                'point' => 0,
                            ],
                            [
                                'article' => 4,
                                'content' => "Poin 75 pemanggilan orang tua.",
                                'point' => 0,
                            ],
                            [
                                'article' => 5,
                                'content' => "Poin 100 santri dikembalikan kepada orang tua.",
                                'point' => 0,
                            ],
                            [
                                'article' => 6,
                                'content' => "Kafaroh dibolehkan denda semen,kebersihan dan ro'an.",
                                'point' => 0,
                            ],
                            [
                                'article' => 7,
                                'content' => "Denda 5 sak semen diberlakukan kasus pacaran,minum minuman keras dan berjudi.",
                                'point' => 0,
                            ],
                            [
                                'article' => 8,
                                'content' => "Bagi santri yang telah mendapatkan izin merokok,jika terjadi pelanggaran yang tercantum pada perjanjian izin merokok bisa mendapatkan sanksi dengan ketentuan yang berlaku.",
                                'point' => 0,
                            ],
                        ]
                    ],
                ],
            ],
        ];

        foreach ($laws as $chapter) {
            foreach ($chapter['section'] as $section) {
                foreach ($section['article'] as $article) {
                    Law::create([
                        'chapter' => $chapter['chapter'],
                        'chapter_title' => $chapter['chapter_title'],
                        'section' => $section['section'],
                        'section_title' => $section['section_title'],
                        'article' => $article['article'],
                        'content' => $article['content'],
                        'point' => $article['point'],
                    ]);
                }
            }
        }
    }
}
