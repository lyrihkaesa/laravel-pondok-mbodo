 @props(['iteration' => 1])

 @php
     $bgColorClass = App\Utilities\TailwindUtility::getBackgroundClass($iteration);
 @endphp

 <!-- Team -->
 <section {!! $attributes->merge([
     'class' => 'mx-auto max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14' . $bgColorClass,
 ]) !!}>
     {{ $slot }}
 </section>
 <!-- End Team -->
