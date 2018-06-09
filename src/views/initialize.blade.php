<!-- WangEditor Resources -->
<link   href="{{ asset('vendor/wangeditor/css/wangEditor.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/wangeditor/js/lib/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('vendor/wangeditor/js/wangEditor.js') }}"></script>

<script>
    $(document).ready(function(){

        var E = window.wangEditor
        var editor = new E('#{{ $pick or 'PickEditor' }}');
        editor.customConfig.uploadImgServer = '{{ config('wangeditor.route.url') }}'
        editor.customConfig.zIndex = 0
        editor.customConfig.uploadFileName = 'ChooseFile[]'
        editor.customConfig.onchange = function (html) {
            $('input[name=\'$name\']').val(html);
        }

        editor.create()
    });
</script>