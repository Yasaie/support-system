@extends('layouts.public.app')

@section('title',' - نمایش تیکت مهمان')
@section('description','نمایش تیکت مهمان')
@section('keywords','نمایش تیکت مهمان')

@section('content')
    @include('layouts.public.header')
    <main class="container main">
        @include('ticket.partial.show')
    </main>
    @include('layouts.public.footer')
@endsection
@section('bodyImport.plugin.append')
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: "textarea.use-rich-editor",
            theme: "modern",
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview | forecolor backcolor emoticons",
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ],
            directionality: 'rtl',
            content_css: "{{ asset('css/font.css') }},{{ asset('css/tinymce-reset.css') }}",
            language: 'fa',
            init_instance_callback: function (editor) {
                editor.on('change', function (e) {
                    editor.triggerSave()
                });
            }
        });
    </script>
@endsection