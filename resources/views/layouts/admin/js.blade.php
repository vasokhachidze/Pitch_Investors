
<script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin/assets/js/adminlte.min.js')}}"></script>
<script src="{{asset('admin/assets/js/Chart.min.js')}}"></script>
<script src="{{asset('admin/assets/js/dashboard3.js')}}"></script>
<script src="{{asset('admin/assets/js/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{asset('admin/assets/js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
  tinymce.init({
    selector: 'textarea',
    selector: 'textarea:not(.COMPANY_ADDRESS)',
    forced_root_block : false,
    height: 150,
    menubar: false,
    plugins: [
    'advlist autolink lists link image charmap print preview anchor textcolor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code help wordcount'
    ],
    toolbar: 'insert | undo redo | formatselect fontselect fontsizeselect | bold italic underline backcolor forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | removeformat | blockquote | help | code',
    content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
    ],
    theme_advanced_fonts : "Andale Mono=andale mono,times;"+
    "Arial=arial,helvetica,sans-serif;"+
    "Arial Black=arial black,avant garde;"+
    "Book Antiqua=book antiqua,palatino;"+
    "Comic Sans MS=comic sans ms,sans-serif;"+
    "Courier New=courier new,courier;"+
    "Georgia=georgia,palatino;"+
    "Helvetica=helvetica;"+
    "Impact=impact,chicago;"+
    "Symbol=symbol;"+
    "Tahoma=tahoma,arial,helvetica,sans-serif;"+
    "Terminal=terminal,monaco;"+
    "Times New Roman=times new roman,times;"+
    "Trebuchet MS=trebuchet ms,geneva;"+
    "Verdana=verdana,geneva;"+
    "Webdings=webdings;"+
    "Wingdings=wingdings,zapf dingbats",
    fontsize_formats: '11px 12px 14px 16px 18px 24px 36px 48px',
    textcolor_map: [
    "000000", "Black",
    "993300", "Burnt orange",
    "333300", "Dark olive",
    "003300", "Dark green",
    "003366", "Dark azure",
    "000080", "Navy Blue",
    "333399", "Indigo",
    "333333", "Very dark gray",
    "800000", "Maroon",
    "FF6600", "Orange",
    "808000", "Olive",
    "008000", "Green",
    "008080", "Teal",
    "0000FF", "Blue",
    "666699", "Grayish blue",
    "808080", "Gray",
    "FF0000", "Red",
    "FF9900", "Amber",
    "99CC00", "Yellow green",
    "339966", "Sea green",
    "33CCCC", "Turquoise",
    "3366FF", "Royal blue",
    "800080", "Purple",
    "999999", "Medium gray",
    "FF00FF", "Magenta",
    "FFCC00", "Gold",
    "FFFF00", "Yellow",
    "00FF00", "Lime",
    "00FFFF", "Aqua",
    "00CCFF", "Sky blue",
    "993366", "Red violet",
    "FFFFFF", "White",
    "FF99CC", "Pink",
    "FFCC99", "Peach",
    "FFFF99", "Light yellow",
    "CCFFCC", "Pale green",
    "CCFFFF", "Pale cyan",
    "99CCFF", "Light sky blue",
    "CC99FF", "Plum"
    ]
  });
</script>