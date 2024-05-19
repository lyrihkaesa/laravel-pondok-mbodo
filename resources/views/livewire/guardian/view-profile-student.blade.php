@push('styles')
    @filamentStyles
    @vite('resources/css/filament/admin/theme.css')
@endpush

@push('scripts')
    @filamentScripts
@endpush

<div class="mx-auto max-w-[85rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-4">
    <h1 class="mb-4 text-lg font-semibold">Profile Santri</h1>
    {{ $this->studentInfolist }}

    @isset($this->student->id)
        <livewire:guardian.list-student-products :studentId="$this->student->id" />
        <livewire:guardian.list-student-enrollments :studentId="$this->student->id" />
    @endisset
</div>
