 <!-- Table -->
 <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
     <thead class="bg-gray-50 dark:bg-slate-800">
         <tr>
             <th scope="col" class="whitespace-nowrap px-6 py-3 text-start">
                 <div class="flex items-center gap-x-2">
                     <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                         Keterangan
                     </span>
                 </div>
             </th>

             <th scope="col" class="whitespace-nowrap px-6 py-3">
                 <div class="flex items-center justify-end gap-x-2">
                     <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                         Biaya
                     </span>
                 </div>
             </th>
         </tr>
     </thead>

     <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
         {{ $slot }}
     </tbody>
 </table>
 <!-- End Table -->
