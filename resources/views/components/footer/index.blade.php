<footer class="mx-auto w-full max-w-[85rem] bg-gray-50 px-4 py-10 dark:bg-gray-950 sm:px-6 lg:px-8">
    <!-- Grid -->
    <div class="mb-10 grid grid-cols-2 gap-6 md:grid-cols-3">
        <div class="col-span-full lg:col-span-1">
            <a class="flex-none text-xl font-semibold dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                href="#" aria-label="Brand">Peta Pondok Mbodo</a>
            <iframe class="mx-auto mt-3 h-[200px] w-full" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d989.7616956258024!2d110.91619417450636!3d-7.120577071179217!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70afe358aa7ec3%3A0xe4c54aaa9c50e928!2sPondok%20Mbodo!5e0!3m2!1sen!2sus!4v1711145401101!5m2!1sen!2sus"></iframe>
        </div>

        <!-- End Col -->
        <div>
            <h4 class="text-xs font-semibold uppercase text-gray-900 dark:text-gray-100">Sekolah Formal</h4>
            <div class="mt-3 grid space-y-3 text-sm">
                @foreach ($organizations['Sekolah Formal'] as $organization)
                    <x-footer-link
                        href="{{ route('organizations.show', ['slug' => $organization->slug]) }}">{{ $organization->name }}</x-footer-link>
                @endforeach
            </div>
        </div>
        <!-- End Col -->

        <div>
            <h4 class="text-xs font-semibold uppercase text-gray-900 dark:text-gray-100">Sekolah Non Formal</h4>
            <div class="mt-3 grid space-y-3 text-sm">
                @foreach ($organizations['Program Jurusan'] as $organization)
                    <x-footer-link
                        href="{{ route('organizations.show', ['slug' => $organization->slug]) }}">{{ $organization->name }}</x-footer-link>
                @endforeach
                @foreach ($organizations['Sekolah Madrasah'] as $organization)
                    <x-footer-link
                        href="{{ route('organizations.show', ['slug' => $organization->slug]) }}">{{ $organization->name }}</x-footer-link>
                @endforeach
            </div>
        </div>
        <!-- End Col -->
    </div>
    <!-- End Grid -->

    <div class="mt-5 border-t border-gray-400 pt-5 dark:border-gray-700">
        <div class="flex items-center justify-center">

            <div class="text-sm text-gray-600 dark:text-gray-400">
                Build with 💖 <a href="https://lyrihkaesa.github.io" target="_blank"
                    class="inline text-blue-600 dark:text-blue-500">Kaesa
                    Lyrih</a> <span x-data x-text="'©' + new Date().getFullYear()">© 2024</span>
            </div>
        </div>
    </div>
    </div>
</footer>
