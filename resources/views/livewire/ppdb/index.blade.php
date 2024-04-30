<x-slot name="header">
    <x-ppdb.header />
</x-slot>

<div class="mx-auto max-w-[85rem]">
    <!-- Hero -->
    <div class="px-4 py-4 sm:px-6 lg:px-8 lg:py-6">
        <!-- Grid -->
        <div class="grid gap-4 md:grid-cols-2 md:items-center md:gap-8 xl:gap-20">
            <div>
                <h1
                    class="block text-3xl font-bold text-gray-800 dark:text-white sm:text-4xl lg:text-6xl lg:leading-tight">
                    Penerimaan Peserta Didik Baru <span class="text-blue-600">(PPDB)</span></h1>
                <p class="mt-3 text-lg text-gray-800 dark:text-gray-400">Telah dibuka penerimaan peserta didik baru.
                    Tahun Ajaran 2024/2025.</p>

                <!-- Buttons -->
                <div class="mt-7 grid w-full gap-3 sm:inline-flex">
                    <a class="inline-flex items-center justify-center gap-x-2 rounded-lg border border-transparent bg-teal-600 px-4 py-3 text-sm font-semibold text-white hover:bg-teal-700 disabled:pointer-events-none disabled:opacity-50"
                        href="#">
                        Pendaftaran Online
                        <svg class="size-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                    <a class="inline-flex items-center justify-center gap-x-2 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-800 shadow-sm hover:bg-gray-50 disabled:pointer-events-none disabled:opacity-50 dark:border-gray-700 dark:bg-slate-900 dark:text-white dark:hover:bg-gray-800"
                        href="#">
                        Unduh Brosur
                    </a>
                </div>
                <!-- End Buttons -->
            </div>
            <!-- End Col -->

            <div class="relative">
                <img class="w-full rounded-md"
                    src="https://images.unsplash.com/photo-1665686377065-08ba896d16fd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=700&h=800&q=80"
                    alt="Image Description">
                <div
                    class="size-full absolute inset-0 -z-[1] -mb-4 -ms-4 me-4 mt-4 rounded-md bg-gradient-to-tr from-gray-200 via-white/0 to-white/0 dark:from-slate-800 dark:via-slate-900/0 dark:to-slate-900/0 lg:-mb-6 lg:-ms-6 lg:me-6 lg:mt-6">
                </div>

                <!-- SVG-->
                <div class="absolute bottom-0 start-0">
                    <svg class="ms-auto h-auto w-2/3 text-white dark:text-slate-900" width="630" height="451"
                        viewBox="0 0 630 451" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="531" y="352" width="99" height="99" fill="currentColor" />
                        <rect x="140" y="352" width="106" height="99" fill="currentColor" />
                        <rect x="482" y="402" width="64" height="49" fill="currentColor" />
                        <rect x="433" y="402" width="63" height="49" fill="currentColor" />
                        <rect x="384" y="352" width="49" height="50" fill="currentColor" />
                        <rect x="531" y="328" width="50" height="50" fill="currentColor" />
                        <rect x="99" y="303" width="49" height="58" fill="currentColor" />
                        <rect x="99" y="352" width="49" height="50" fill="currentColor" />
                        <rect x="99" y="392" width="49" height="59" fill="currentColor" />
                        <rect x="44" y="402" width="66" height="49" fill="currentColor" />
                        <rect x="234" y="402" width="62" height="49" fill="currentColor" />
                        <rect x="334" y="303" width="50" height="49" fill="currentColor" />
                        <rect x="581" width="49" height="49" fill="currentColor" />
                        <rect x="581" width="49" height="64" fill="currentColor" />
                        <rect x="482" y="123" width="49" height="49" fill="currentColor" />
                        <rect x="507" y="124" width="49" height="24" fill="currentColor" />
                        <rect x="531" y="49" width="99" height="99" fill="currentColor" />
                    </svg>
                </div>
                <!-- End SVG-->
            </div>
            <!-- End Col -->
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Hero -->
    {{-- Alur Pendaftaran --}}
    <section class="bg-gray-50 px-4 py-4 dark:bg-gray-950 sm:px-6 lg:px-8 lg:py-6">
        <div class="grid gap-4 md:grid-cols-2 md:items-center md:gap-8 xl:gap-20">
            <div>
                <h2
                    class="block text-xl font-bold text-gray-800 dark:text-white sm:text-2xl lg:text-3xl lg:leading-tight">
                    <span class="text-blue-600">Alur</span> Pendaftaran
                </h2>
                <p class="mt-3 border-l-4 border-teal-400 pl-4 text-base text-gray-800 dark:text-gray-400">Calon Peserta
                    Didik baru dapat mendaftar secara mandiri melalui website PPDB Online Pondok Mbodo dan mengisi
                    formulir pendaftaran sesuai data diri peserta.</p>
                <p class="mt-3 border-l-4 border-teal-400 pl-4 text-base text-gray-800 dark:text-gray-400">Calon Peserta
                    Didik baru dapat langsung datang ke Yayasan Pondok Mbodo membawa berkas persyaratan yang dibutuhkan.
                </p>
                <p class="mt-3 border-l-4 border-teal-400 pl-4 text-base text-gray-800 dark:text-gray-400">Setelah
                    dinyatakan diterima, peserta PPDB membayar biaya daftar ulang Sebesar Rp. 180.000,-</p>
                <p class="mt-3 border-l-4 border-teal-400 pl-4 text-base text-gray-800 dark:text-gray-400">Berkas
                    Pendaftaran dan Biaya Daftar Ulang
                    diserahkan langsung ke Yayasan Pondok Mbodo.</p>
            </div>
            <!-- End Col -->

            <div>
                <h2
                    class="block text-xl font-bold text-gray-800 dark:text-white sm:text-2xl lg:text-3xl lg:leading-tight">
                    <span class="text-blue-600">Syarat</span> Pendaftaran
                </h2>
                <p class="mt-3 border-l-4 border-teal-400 pl-4 text-base text-gray-800 dark:text-gray-400">
                    Satu lembar Fotocopy Kartu Keluarga
                </p>
                <p class="mt-3 border-l-4 border-teal-400 pl-4 text-base text-gray-800 dark:text-gray-400">
                    Satu lembar Fotocopy Akta Kelahiran
                </p>
                <p class="mt-3 border-l-4 border-teal-400 pl-4 text-base text-gray-800 dark:text-gray-400">Satu lembar
                    Fotocopy SKHUN Terlegalisir
                </p>
                <p class="mt-3 border-l-4 border-teal-400 pl-4 text-base text-gray-800 dark:text-gray-400">Satu lembar
                    Fotocopy Ijazah Terlegalisir</p>
                <p class="mt-3 border-l-4 border-teal-400 pl-4 text-base text-gray-800 dark:text-gray-400">Satu lembar
                    Fotocopy KTP Orang Tua/Wali</p>
                <p class="mt-3 border-l-4 border-teal-400 pl-4 text-base text-gray-800 dark:text-gray-400">
                    Masing-masing 6 lembar Pass Foto 3x4 dan 2x3</p>
            </div>
            <!-- End Col -->
        </div>
    </section>
    {{-- End Alur Pendaftaran --}}
    {{-- Contact --}}
    <section class="px-4 py-4 sm:px-6 lg:px-8 lg:py-6">
        <!-- Title -->
        <div class="mx-auto mb-5 max-w-2xl text-center lg:mb-10">
            <h2 class="text-2xl font-bold dark:text-white md:text-4xl md:leading-tight">Konsultasi Pendaftaran</h2>
        </div>
        <!-- End Title -->
        <!-- Grid -->
        <div class="grid grid-cols-2 gap-8 md:grid-cols-3 md:gap-12">
            <div class="text-center">
                <img class="sm:size-48 lg:size-60 mx-auto rounded-xl"
                    src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=900&h=900&q=80"
                    alt="Image Description">
                <div class="mt-2 sm:mt-4">
                    <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200 sm:text-base lg:text-lg">
                        Bu Yani
                    </h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 sm:text-sm lg:text-base">
                        082136687558
                    </p>
                </div>
            </div>
            <!-- End Col -->

            <div class="text-center">
                <img class="sm:size-48 lg:size-60 mx-auto rounded-xl"
                    src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=900&h=900&q=80"
                    alt="Image Description">
                <div class="mt-2 sm:mt-4">
                    <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200 sm:text-base lg:text-lg">
                        Bu Ulfa
                    </h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 sm:text-sm lg:text-base">
                        082134125855
                    </p>
                </div>
            </div>
            <!-- End Col -->

            <div class="text-center">
                <img class="sm:size-48 lg:size-60 mx-auto rounded-xl"
                    src="https://images.unsplash.com/photo-1548142813-c348350df52b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=900&h=900&q=80"
                    alt="Image Description">
                <div class="mt-2 sm:mt-4">
                    <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200 sm:text-base lg:text-lg">
                        TU Sekolah
                    </h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 sm:text-sm lg:text-base">
                        085803036153
                    </p>
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Grid -->
    </section>
    {{-- End-Contact --}}
</div>
