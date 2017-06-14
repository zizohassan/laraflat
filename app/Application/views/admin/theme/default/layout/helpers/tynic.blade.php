<!-- TinyMCE -->
<script src="{{ url('/') }}/admin/plugins/tinymce/tinymce.js"></script>
<script>
    function elFinderBrowser (field_name, url, type, win) {
        tinymce.activeEditor.windowManager.open({
            file: '{{ url('/') }}/admin/plugins/tinymce/plugins/elfinder/elfinder.html',// use an absolute path!
            title: 'elFinder 2.0',
            width: 900,
            height: 450,
            resizable: 'yes'
        }, {
            setUrl: function (url) {
                win.document.getElementById(field_name).value = url;
            }
        });
        return false;
    }
    tinymce.init({
        selector: "textarea.tinymce",
        theme: "modern",
        height: 300,
        file_browser_callback : elFinderBrowser,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern '
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true
    });
    tinymce.suffix = ".min";
    tinyMCE.baseURL = '{{ url('/') }}/admin/plugins/tinymce';
    ////imagetools
</script>