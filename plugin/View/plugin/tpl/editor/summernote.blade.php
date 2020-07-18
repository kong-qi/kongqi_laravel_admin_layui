<link rel="stylesheet" href="{{ ___('editor/summernote/summernote-lite.css') }}">
<script src="{{ ___('editor/summernote/summernote-lite.js') }}"></script>
@if(env('LANG')=='cn')
    <script src="{{ ___('editor/summernote/lang/summernote-zh-CN.js') }}"></script>
@endif
<script src="{{ ___('editor/summernote/plugin/uploader/upload-ext.js') }}"></script>
<script src="{{ ___('editor/summernote/plugin/videolayui/upload-video.js') }}"></script>
<script>
  function summernote (obj, default_config) {
    var config = {
      minHeight: 150,
      tabsize: 4,
      lang: 'zh-CN',
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'videolayui', 'uploader']],
        ['view', ['fullscreen', 'codeview']],
      ],

    };
    default_config = default_config || {};
    config = $.extend({}, config, default_config)
    var ed = $("#" + obj).summernote(config);
    return ed;
  }
</script>