@props(['src'])

<object data="{{ $src }}" type="application/pdf" height="100%">
    <embed src="{{ $src }}" type="application/pdf" height="100%">
    <p>{{ __('This browser does not support PDFs. Please download the PDF to view it:') }} <a href="{{ $src }}"
            target="_blank">{{ __('Download') }} PDF</a>.</p>
    </embed>
</object>
