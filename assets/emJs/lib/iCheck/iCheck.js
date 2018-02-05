
// 체크박스 / 오디오박스 꾸미기
$(document).ready(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square',
        radioClass: 'iradio_square',
    });
    // all checked js     
    $('#check-all').on('ifChecked', function(event) {
	    $('.check').iCheck('check');
	});
	$('#check-all').on('ifUnchecked', function(event) {
	    $('.check').iCheck('uncheck');
	});
    // Removed the checked state from "All" if any checkbox is unchecked
	$('#check-all').on('ifChanged', function(event){
	    if(!this.changed) {
	        this.changed=true;
	        $('#check-all').iCheck('check');
	        $(".btn-next-pre").addClass("btn-next");
	    } else {
	        this.changed=false;
	        $('#check-all').iCheck('uncheck');
	        $(".btn-next-pre").removeClass("btn-next");
	    }
	    $('#check-all').iCheck('update');
	});
});
