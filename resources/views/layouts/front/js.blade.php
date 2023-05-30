<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js "></script>
<script src="{{asset('front/assets/js/sweetalert2.min.js');}}"></script>
<script src="{{asset('front/assets/js/custom.js');}}"></script>
<script src="{{asset('front/assets/js/cropzee.js');}}"></script>
<!-- <script src="{{asset('front/assets/js/jquery.multiselect.js');}}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
{{-- Start Script for chat ajax call --}}
<script>
    var chatCLicked = false;
    $(".chating-box").hide();
    $(document).on("click", ".close-chat", function() {
        $(".chating-box").hide();
    });

    $(".notification-baar").click(function (e) { 
        $(".header_chat_list").toggle();
        /* $(".header_chat_list").show(); */
        $(".header_chat_list").css("top", "35px");
    });
    $(".chat-peopel").click(function (e) { 
        // $(this).parent.hide();
    });

    $(document).ready(function() {
        get_connection_list();
        /* $.ajax({
            url: "{{ route('front.chat.chatConnectionList') }}",
            type: "POST",
            headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            data: '',
            success: function(response) {
                $("#connectionList_ul").html(response);
            }
        }); */
    });

    $(document).on("click", "#msg_send", function() {
        sendMsg();
    });
    $('#vMessage').keypress(function(event) {
        // var keycode = (event.keyCode ? event.keyCode : event.which);
        var keycode = (event.which);
        if (keycode == '13') {
            sendMsg();
        }
    });

    $(document).on("click", ".chat-person-profile", function() 
    {
        $(".header_chat_list").hide();
        chatCLicked = true;
        var loginid = $(this).attr("data-loginid");
        var iSenderId = $(this).attr("data-iSenderId");
        var iReceiverId = $(this).attr("data-iReceiverId");
        var vReceiverContactPersonName = $(this).attr("data-vreceivercontactpersonname");
        var vReceiverContactPersonPhoneNo = $(this).attr("data-vreceivercontactpersonphoneno");
        var iConnectionId = $(this).attr("data-iConnectionId");
        var current_chat_profile_image = $(this).attr("data-current_chat_profile_image");
        var senderProfile = $(this).attr("data-senderProfile");
        var receiverProfile = $(this).attr("data-receiverProfile");
        var contractStatus = $(this).attr("data-contractStatus");
        var eConnectionStatus = $(this).attr("data-eConnectionStatus");
        var iContractId = $(this).attr("data-iContractId");
        var read = $(this).attr("data-read");
        var msgRecId = $(this).attr("data-msgRecId");
        var msgSenderId = $(this).attr("data-msgSenderId");
        var contractAmount = $(this).attr("data-contractAmount");
        var contractCode = $(this).attr("data-contractCode");


        if (senderProfile == 'Advisor' && iSenderId == loginid  && contractStatus == "" && !(eConnectionStatus =='Hold' || eConnectionStatus =='Reject')) 
        {
            $("#advisor_create_contract").show();
            $("#new_contract").hide();
            $("#contract_make_payment").hide();
        } 
        else if(receiverProfile == 'Advisor' && iReceiverId == loginid && contractStatus == "" && !(eConnectionStatus =='Hold' || eConnectionStatus =='Reject'))
        {
            $("#advisor_create_contract").show();
            $("#new_contract").hide();
            $("#contract_make_payment").hide();
        }
        else if (senderProfile == 'Advisor' && iSenderId == loginid && contractStatus == 'Created') 
        {   $("#new_contract").show();
            $("#advisor_create_contract").hide();
            $("#contract_make_payment").hide();
        } 
        else if(receiverProfile == 'Advisor' && iReceiverId == loginid && contractStatus == 'Created')
        {   $("#new_contract").show();
            $("#advisor_create_contract").hide();
            $("#contract_make_payment").hide();
        }
        else if (senderProfile != 'Advisor' && iSenderId == loginid && contractStatus == 'Created') 
        {
            $("#contract_make_payment").show();
            $("#new_contract").hide();
            $("#advisor_create_contract").hide();
        } 
        else if(receiverProfile != 'Advisor' && iReceiverId == loginid && contractStatus == 'Created')
        {
            $("#contract_make_payment").show();
            $("#new_contract").hide();
            $("#advisor_create_contract").hide();
        }
        else {
          $("#advisor_create_contract").hide();
          $("#new_contract").hide();        
          $("#contract_make_payment").hide();
        }
        
        /* $('#persom-name').html(vReceiverContactPersonName);
        $('#persom-phone').html(vReceiverContactPersonPhoneNo);
        $('#current_chat_profile_image').attr('src', current_chat_profile_image); */
        $('#persom-name').html(vReceiverContactPersonName);
        $('.persom-phone').html(vReceiverContactPersonPhoneNo);
        $('.current_chat_profile_image').attr('src', current_chat_profile_image);
        $('#msg_send').attr('iSenderId', iSenderId);
        $('#msg_send').attr('iReceiverId', iReceiverId);
        $('#msg_send').attr('vReceiverContactPersonName', vReceiverContactPersonName);
        $('#msg_send').attr('iConnectionId', iConnectionId);
        $('#msg_send').attr('read', read);
        $('#msg_send').attr('msgRecId', msgRecId);
        $('#msg_send').attr('msgSenderId', msgSenderId);
        $('#iConnectionId').val(iConnectionId);
        $('#iContractId').val(iContractId);
        $('#iSenderId').val(iSenderId);
        $('#iReceiverId').val(iReceiverId);
        $('#contractAmount').text(contractAmount);
        $('#contractCode').text(contractCode);
        $('#eSenderProfileType').val(senderProfile);
        $('#eReceiverProfileType').val(receiverProfile);
        $(".chating-box").show();
        doAjax();
    });

    function doAjax() {
        if (chatCLicked) {
            var iSenderId = $('#msg_send').attr("iSenderId");
            var iReceiverId = $('#msg_send').attr("iReceiverId");
            var vReceiverContactPersonName = $('#msg_send').attr("vReceiverContactPersonName");
            var iConnectionId = $('#msg_send').attr("iConnectionId");
            var read = $('#msg_send').attr("read");
            var msgRecId = $('#msg_send').attr("msgRecId");
            var msgSenderId = $('#msg_send').attr("msgSenderId");

            $.ajax({
                url: "{{ url('chatHistory') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    iSenderId: iSenderId,
                    iReceiverId: iReceiverId,
                    vReceiverContactPersonName: vReceiverContactPersonName,
                    iConnectionId: iConnectionId,
                    msgRecId: msgRecId,
                    msgSenderId: msgSenderId,
                    read: read,
                },
                success: function(response) {
                    $(".cheating-area").html(response);
                },
                complete: function(data) {
                    setTimeout(doAjax, 2000);
                    $('.cheating-area').animate({
                        scrollTop: $(".cheating-area").height() * 10
                    }, 0);
                }
            });
        }
    }

    function sendMsg() {
        var vMessage = $('#vMessage').val();
        var iSenderId = $('#msg_send').attr("iSenderId");
        var iReceiverId = $('#msg_send').attr("iReceiverId");
        var iConnectionId = $('#msg_send').attr("iConnectionId");

        if (vMessage.length > 0) {
            $.ajax({
                url: "{{ url('chatSend') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    vMessage: vMessage,
                    iSenderId: iSenderId,
                    iReceiverId: iReceiverId,
                    iConnectionId: iConnectionId,
                },
                success: function(response) {
                    $('#vMessage').val('');
                }
            });
        }
    }
    function get_connection_list() {
        $.ajax({
            url: "{{ route('front.chat.chatConnectionList') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: '',
            success: function(response) {
                /* $("#connectionList_ul").html(response); */
                $(".connectionList_ul").html(response);
                var notification_status = $("#chat_notification_status").val();
                if(notification_status == "No")
                {
                    $("#chat_exist_a").addClass('faa-ring animated');
                    /*$("#chat_exist_i").addClass('text-info');*/
                    $("#mainNotification").addClass('notofication-chat');
                    $("#notificationDot").addClass('notification-round-dot');
                    $("#chat_exist_i").css("color", "#ff9a34");
                }
                else
                {
                    $("#chat_exist_a").removeClass('faa-ring animated');
                    /*$("#chat_exist_i").removeClass('text-info');*/
                    $("#mainNotification").removeClass('notofication-chat');
                    $("#notificationDot").removeClass('notification-round-dot');
                    $("#chat_exist_i").css("color", "");                    
                }                
            },
            complete: function(data) {
                setTimeout(get_connection_list, 3000);
            }
        });
    }
</script>
{{-- End Script for chat ajax call --}}

<script type="text/javascript" src="{{asset('admin/assets/js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
  tinymce.init({
    selector: '#tFacility1,#tListProductService',
    onchange_callback : "markChanged",
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