// Resize page header
$('.page-header').each(function () {
    var $header = $(this),
        headerHeight = $header.outerHeight(),
        headerPaddingTop = parseInt($header.css('paddingTop'), 10),
        headerPaddingBottom = parseInt($header.css('paddingBottom'), 10);
    $(window).on('scroll', $.throttle(1000 / 60, function () {
        var scroll = $(this).scrollTop(),
            styles = {};
        if (scroll > 0) {
            if (scroll < headerHeight) {
                styles = {
                    paddingTop: headerPaddingTop - scroll / 2,
                    paddingBottom: headerPaddingBottom - scroll / 2
                };
                $(".site-logo img").css("max-width",150);
                
            } else {
                styles = {
                    paddingTop: 0,
                    paddingBottom: 0
                };
            }
        } else {
            styles = {
                paddingTop: '',
                paddingBottom: ''
            }
            $(".site-logo img").css("max-width","100%");
        }
        $header.css(styles);
    }));
});

// toastr 
function showToast(type, text) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    
    if(type == "SUCCESS"){
        toastr.success('<p>' + text + '</p>', {});
    }
    
    if(type == "ERROR"){
        toastr.error('<p>' + text + '</p>', {
            showEasing : 'linear'
        });
    }
}