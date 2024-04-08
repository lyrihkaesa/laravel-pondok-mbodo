  @props(['extracurricular'])

  <!-- Card -->
  <div
      class="group flex h-full w-72 flex-shrink-0 flex-col rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-slate-900 dark:shadow-slate-700/[.7]">
      <div class="flex h-52 flex-col items-center justify-center overflow-hidden rounded-t-xl bg-blue-600">
          <img src="{{ asset('storage/' . $extracurricular->thumbnail) }}" alt="{{ $extracurricular->name }}">
      </div>
      <div class="p-4 md:p-6">
          <span class="mb-1 block text-xs font-semibold uppercase text-blue-600 dark:text-blue-500">
              {{ $extracurricular->category }}
          </span>
          <h3 class="truncate text-xl font-semibold text-gray-800 dark:text-gray-300 dark:hover:text-white">
              {{ $extracurricular->name }}
          </h3>
          <p class="mt-3 text-gray-500">
              {{ $extracurricular->description }}
          </p>
      </div>
      <div
          class="mt-auto flex divide-x divide-gray-200 border-t border-gray-200 dark:divide-gray-700 dark:border-gray-700">
          <a class="inline-flex w-full items-center justify-center gap-x-2 rounded-b-xl bg-white px-4 py-3 text-sm font-medium text-gray-800 shadow-sm hover:bg-gray-50 disabled:pointer-events-none disabled:opacity-50 dark:border-gray-700 dark:bg-slate-900 dark:text-white dark:hover:bg-gray-800"
              href="#">
              Lihat Selengkapnya
          </a>
      </div>
  </div>
  <!-- End Card -->
