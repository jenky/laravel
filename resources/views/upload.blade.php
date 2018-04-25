@extends('layouts.master')

@push('css')
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/3.1.2/plupload.full.min.js"></script>
<script src="{{ asset('js/upload.js') }}"></script>
<script>
$(function() {
    createUploader('test');
});
</script>
@endpush

@section('body')
<div class="container">
    {!! plupload('test', route('upload')) !!}
</div>
@endsection
