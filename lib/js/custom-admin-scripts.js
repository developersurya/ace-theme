jQuery(document).ready(function ($) {

    /* ----------- js hide admin menu options -------------------------------- */
    //toolset types
    // $("#toplevel_page_toolset-dashboard").css('display', 'none');
    //
    // //ajax load more
    // $("#toplevel_page_ajax-load-more").css('display', 'none');
    //
    // //print/pdf
    // $("#toplevel_page_bws_panel").css('display', 'none');
    //
    // //plugin update : top bar
    // $("#wp-admin-bar-updates").css("display", "none");
    //
    // //yoast seo
    // $("#toplevel_page_wpseo_dashboard").css("display", "none");
    //
    // //yoast seo : top bar
    // $("#wp-admin-bar-wpseo-menu").css("display", "none");
    //
    // //comments : top bar
    // $("#wp-admin-bar-comments").css("display", "none");
    //
    // //instagram feed
    // $("#toplevel_page_sb-instagram-feed").css("display", "none");
    //
    // //form
    // $("#toplevel_page_gf_edit_forms ul li:nth-child(3)").css("display", "none");
    // $("#toplevel_page_gf_edit_forms ul li:nth-child(7)").css("display", "none");
    // $("#toplevel_page_gf_edit_forms ul li:nth-child(8)").css("display", "none");
    // $("#wp-admin-bar-gform-forms-new-form").css("display", "none");

    /*---------------- end ---------------------------------------------------- */


    //testimonial category: default selected if not any checked
    if($('input[name="tax_input[testimonial-category][]"]:checked').length == 0) {
        $("#in-testimonial-category-50").attr("checked", "checked");
    }
});

    function daysInMonth(year, month) {
    month++;
    return new Date(year, month, 0).getDate();
}

function CompareDates( d1, d2 ) {
    if ( d1 < d2 ) return -1; // d1 is in the past of d2
    if ( d1 > d2 ) return 1;  // d1 is in the future of d2
    return 0;
}

jQuery(document).ready(function ($) {

    if($('.acf-field-repeater.acf-field-56826fd104114').length > 0) {
        var str = '<div class="bulk-dates"><p>Generate Small Group Journey Departure Dates</p>';
        str += '<label for="generate-trip-days">Days: <select multiple="multiple" id="generate-trip-days"><option value="" selected="selected">- Select Days</option><option value="0">Sunday</option><option value="1">Monday</option><option value="2">Tuesday</option><option value="3">Wednesday</option><option value="4">Thursday</option><option value="5">Friday</option><option value="6">Saturday</option></select></label>';
        str += '<label for="generate-trip-months">Months: <select multiple="multiple" id="generate-trip-months"><option value="" selected="selected">- Select Months</option><option value="0">January</option><option value="1">February</option><option value="2">March</option><option value="3">April</option><option value="4">May</option><option value="5">June</option><option value="6">July</option><option value="7">August</option><option value="8">September</option><option value="9">October</option><option value="10">November</option><option value="11">December</option></select></label>';
        str += '<label for="generate-trip-year">Year: <select id="generate-trip-year"><option value="" selected="selected">- Select Year</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option></select></label>';
        str += '<p><div>Enter default value</div><label for="default-departure-price">Price: <input type="text" id="default-departure-price"></label>';
        str += '<label for="default-departure-discount">Discount: <input type="text" id="default-departure-discount"></label>';
        str += '<label for="default-departure-status"> Status: <select id="default-departure-status"><option value="guaranteed">Book Now</option><option value="limited">Inquire Now</option><option value="closed">Closed</option></select></label></p>';
        str += '<p id="add-generated-departure-dates"><a href="#" class="button button-primary button-large">Generate</a></p>';
        str += '</div>';
        $(".acf-field-repeater.acf-field-56826fd104114").prepend(str);
    }

    $(document).on('click', '#add-generated-departure-dates a', function (e) {
        e.preventDefault();
        var i = $(this);
        i.addClass('disable-click');
        var days = $('#generate-trip-days').val();
        var months = $('#generate-trip-months').val();
        var year = $('#generate-trip-year').val();
        if(days == '' || months == '' || year == '') {
            alert('Please select days, months and year.');
            i.removeClass('disable-click');
            return false;
        } else {
            var sunday = new Array();
            var monday = new Array();
            var tuesday = new Array();
            var wednesday = new Array();
            var thursday = new Array();
            var friday = new Array();
            var saturday = new Array();
            var m = months.toString().split(',');
            var d = days.toString().split(',');
            var duration = $('#acf-field_56825e4aa9408').val();
            var price = $('#default-departure-price').val();
            var discount = $('#default-departure-discount').val();
            var status = $('#default-departure-status').val();
            if(duration == '') {
                alert('Please enter Trip total days (duration).');
                i.removeClass('disable-click');
                return false;
            }
            if(price == '' || discount == '' || status == '') {
                alert('Please enter default value for Price, Discount and Status.');
                i.removeClass('disable-click');
                return false;
            }
            m.forEach(function(month) {
                var inMonth = daysInMonth(year, month);
                for( var i = 1; i <= inMonth; i++ ) {
                    var newDate = new Date(year, month, i);
                    if( newDate.getDay() == 0 && d.indexOf('0') >= 0 ) { // If Sunday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        sunday.push(_d+'/'+_m+'/'+year);
                    }
                    if( newDate.getDay() == 1 && d.indexOf('1') >= 0 ) { // If Monday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        monday.push(_d+'/'+_m+'/'+year);
                    }
                    if( newDate.getDay() == 2 && d.indexOf('2') >= 0 ) { // If Tuesday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        tuesday.push(_d+'/'+_m+'/'+year);
                    }
                    if( newDate.getDay() == 3 && d.indexOf('3') >= 0 ) { // If Wednesday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        wednesday.push(_d+'/'+_m+'/'+year);
                    }
                    if( newDate.getDay() == 4 && d.indexOf('4') >= 0 ) { // If Thursday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        thursday.push(_d+'/'+_m+'/'+year);
                    }
                    if( newDate.getDay() == 5 && d.indexOf('5') >= 0 ) { // If Friday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        friday.push(_d+'/'+_m+'/'+year);
                    }
                    if( newDate.getDay() == 6 && d.indexOf('6') >= 0 ) { // If Saturday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        saturday.push(_d+'/'+_m+'/'+year);
                    }
                }
            });
            var all_dates = sunday.concat(monday, tuesday, wednesday, thursday, friday, saturday);
            //console.log(all_dates);
            var allDates = Array();
            all_dates.forEach(function(dt) {
                var _dt = dt.split('/');
                allDates.push(new Date(_dt[2], _dt[1], _dt[0]));
            });
            allDates.sort( CompareDates );
            var date_output = Array();
            allDates.forEach(function(_date) {
                var fDate = new Date(_date);
                var dDate = new Date(_date);
                dDate.setDate(dDate.getDate() + (duration - 1));
                var _month = ('0'+(fDate.getMonth() + 1)).slice(-2);
                var _day = ('0'+(fDate.getDate())).slice(-2);
                var _dMonth = ('0'+(dDate.getMonth() + 1)).slice(-2);
                var _dDay = ('0'+(dDate.getDate())).slice(-2);
                date_output.push(_month+'/'+_day+'/'+fDate.getFullYear()+' - '+_dMonth+'/'+_dDay+'/'+dDate.getFullYear());
            });
            //console.log(date_output);
            date_output.forEach(function(i) {
                $('.acf-field-repeater.acf-field-56826fd104114 ul.acf-actions .acf-button').trigger('click');
                var tr = $('.acf-field-repeater.acf-field-56826fd104114 table.acf-table tr:last').prev();
                tr.children('td:nth-child(2)').find('input').val(i);
                tr.children('td:nth-child(3)').find('input').val(price);
                tr.children('td:nth-child(4)').find('input').val(discount);
                tr.children('td:nth-child(5)').find('select').val(status);
            });
            $('#generate-trip-days, #generate-trip-months, #generate-trip-year, #default-departure-price, #default-departure-discount, #default-departure-status').val('');
        }
        i.removeClass('disable-click');
    });


    $("#acf-field_5682555d9b2ce").attr("readonly", "readonly");
    if ($('body.post-new-php').length != 0) {
        var response = '';
        // ------------------------ readonly for trip code -----------------------------
        
        $.ajax({ // -------------------------- trip code -----------------------
            type: "GET",
            url: "/wp-content/themes/acethehimalaya/inc/custom-admin.php",
            async: false,
            success: function (data) {
                //console.log(data);
                var dum = $("#acf-field_5682555d9b2ce").val();
                if (dum != '') {
                    $("#acf-field_5682555d9b2ce").val(dum);
                } else {
                    $("#acf-field_5682555d9b2ce").val(data);
                }
            }
        });
    }// ---------------------- end of trip code generate ---------------------


    // ------------------------------ date picker feature, auto price and discount ---------------------------
    $(".acf-actions.acf-hl a").attr("id", "btn-add");

    // --------------------------- for date-picker ------------------------------
    $(document).on("focus", ".acf-field-56826fd104114 table.acf-table td.static-date input", function (event) {
        $(this).daterangepicker();
    });


    $(".acf-button#btn-add").on("click", function () {

        // ------------------- for price -----------------------------------
        var td = jQuery('.acf-field-56826fd104114 table.acf-table td.copy-price').length;
        var cost = $("#acf-field_5683b18ef8ea0").val();
        td = td - 1;
        jQuery('.acf-field-56826fd104114 table.acf-table td.copy-price').each(function (index, value) {
            if (index == td) {
                jQuery(this).children('.acf-input').children('.acf-input-wrap').children('input').val(cost);
            }
        });

        // ----------------------- for discount -----------------------
        var tx = jQuery('.acf-field-56826fd104114 table.acf-table td.copy-discount').length;
        var discount = $("#acf-field_5682301163ebc").val();
        tx = tx - 1;
        jQuery('.acf-field-56826fd104114 table.acf-table td.copy-discount').each(function (index, value) {
            if (index == tx) {
                jQuery(this).children('.acf-input').children('.acf-input-wrap').children('input').val(discount);
            }
        });

    });


    // ------------------------ end of date picker ------------------------------

    // ------------ check remove bulk feature --------------------
    $('.acf-th-true_false').append('<input type="button" value="Remove Checked" id="remove" class="acf-button btn btn-danger" style="font-size:12px;">'); //<input type="button" value="Remove All" id="checkAll">&nbsp;

    $("#remove").on("click", function () {
        $('.acf-field-56826fd104114 table.acf-table tbody tr').has('input:checked').remove();
    });

    /* $("#checkAll").on("click", function () {
     $(".acf-field-56826fd104114 table.acf-table tbody input:checkbox").prop('checked', $(this).prop("checked"));
     $('.acf-field-56826fd104114 table.acf-table tbody tr').has('input:checked').remove();
     });*/
    // ------------------- end of bulk feature -----------------

    //testimonial : youtube video
    if($('body.post-type-testimonial').length != 0) {
        var videoCode = $("#acf-field_57e5194b28879").val();
        $(".acf-field-57e5194b28879").append('<iframe width="510" height="315" src="https://www.youtube.com/embed/' + videoCode + '" frameborder="0" allowfullscreen style="padding-top:10px;" id="vid"></iframe><span id="delVideo" class="acf-icon -cancel dark"></span>');
        $("#delVideo").on("click", function(){
            if(confirm("Are you sure to delete?")) {
                $("#vid").remove();
                $("#delVideo").remove();
                $("#acf-field_57e5194b28879").val('');

            } else {
                return false;
            }
        });
    }


});

//new date genereate code
jQuery(document).ready(function ($) {

    if($('.acf-field-repeater.acf-field-59f9a9d550a9b').length > 0) {
        var str = '<div class="bulk-dates"><p>Generate Small Group Journey Departure Dates</p>';
        str += '<label for="generate-trip-days">Days: <select multiple="multiple" id="generate-trip-days"><option value="" selected="selected">- Select Days</option><option value="0">Sunday</option><option value="1">Monday</option><option value="2">Tuesday</option><option value="3">Wednesday</option><option value="4">Thursday</option><option value="5">Friday</option><option value="6">Saturday</option></select></label>';
        str += '<label for="generate-trip-months">Months: <select multiple="multiple" id="generate-trip-months"><option value="" selected="selected">- Select Months</option><option value="0">January</option><option value="1">February</option><option value="2">March</option><option value="3">April</option><option value="4">May</option><option value="5">June</option><option value="6">July</option><option value="7">August</option><option value="8">September</option><option value="9">October</option><option value="10">November</option><option value="11">December</option></select></label>';
        str += '<label for="generate-trip-year">Year: <select id="generate-trip-year"><option value="" selected="selected">- Select Year</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option></select></label>';
        str += '<p><div>Enter default value</div><label for="default-departure-price">Price: <input type="text" id="default-departure-price"></label>';
        str += '<label for="default-departure-discount">Discount: <input type="text" id="default-departure-discount"></label>';
        str += '<label for="default-departure-status"> Status: <select id="default-departure-status"><option value="guaranteed">Book Now</option><option value="limited">Inquire Now</option><option value="closed">Closed</option></select></label></p>';
        str += '<p ><a href="#" class="button button-primary button-large generate-btn">Generate</a></p>';
        str += '</div>';
        $(".acf-field-repeater.acf-field-59f9a9d550a9b").prepend(str);
    }

    $(document).on('click', '.generate-btn', function (e) {
        e.preventDefault();
        var i = $(this);
        i.addClass('disable-click');
        var days = $('#generate-trip-days').val();
        var months = $('#generate-trip-months').val();
        var year = $('#generate-trip-year').val();
        //debugger;
        //
        if(days == '' || months=='' || year=='' ) {
            alert('Please select days, months and year.');
            i.removeClass('disable-click');
            return false;
        } else {
            var sunday = new Array();
            var monday = new Array();
            var tuesday = new Array();
            var wednesday = new Array();
            var thursday = new Array();
            var friday = new Array();
            var saturday = new Array();
            var m = months.toString().split(',');
            var d = days.toString().split(',');
            //var duration = $('#acf-field_56825e4aa9408').val();//total days for now 14
            var duration = $('#acf-field_59f9abe209d87').val();//total days for now 14
            var price = $('#default-departure-price').val();
            var discount = $('#default-departure-discount').val();
            var status = $('#default-departure-status').val();
            //Duration  
            if(duration == '') {
                alert('Please enter Trip total days (duration).');
                i.removeClass('disable-click');
                return false;
            }
            if(price == '' || discount == '' || status == '') {
                alert('Please enter default value for Price, Discount and Status.');
                i.removeClass('disable-click');
                return false;
            }
            m.forEach(function(month) {
                var inMonth = daysInMonth(year, month);
                for( var i = 1; i <= inMonth; i++ ) {
                    var newDate = new Date(year, month, i);
                    if( newDate.getDay() == 0 && d.indexOf('0') >= 0 ) { // If Sunday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        sunday.push(_d+'/'+_m+'/'+year);
                    }
                    if( newDate.getDay() == 1 && d.indexOf('1') >= 0 ) { // If Monday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        monday.push(_d+'/'+_m+'/'+year);
                    }
                    if( newDate.getDay() == 2 && d.indexOf('2') >= 0 ) { // If Tuesday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        tuesday.push(_d+'/'+_m+'/'+year);
                    }
                    if( newDate.getDay() == 3 && d.indexOf('3') >= 0 ) { // If Wednesday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        wednesday.push(_d+'/'+_m+'/'+year);
                    }
                    if( newDate.getDay() == 4 && d.indexOf('4') >= 0 ) { // If Thursday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        thursday.push(_d+'/'+_m+'/'+year);
                    }
                    if( newDate.getDay() == 5 && d.indexOf('5') >= 0 ) { // If Friday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        friday.push(_d+'/'+_m+'/'+year);
                    }
                    if( newDate.getDay() == 6 && d.indexOf('6') >= 0 ) { // If Saturday
                        var _d = ('0'+i).slice(-2);
                        var _m = ('0'+month).slice(-2);
                        saturday.push(_d+'/'+_m+'/'+year);
                    }
                }
            });
            var all_dates = sunday.concat(monday, tuesday, wednesday, thursday, friday, saturday);
            console.log(all_dates);
            var allDates = Array();
            all_dates.forEach(function(dt) {
                var _dt = dt.split('/');
                allDates.push(new Date(_dt[2], _dt[1], _dt[0]));
            });
            allDates.sort( CompareDates );
            var date_output = Array();
            allDates.forEach(function(_date) {
                var fDate = new Date(_date);
                var dDate = new Date(_date);
                dDate.setDate(dDate.getDate() + (duration - 1));
                var _month = ('0'+(fDate.getMonth() + 1)).slice(-2);
                var _day = ('0'+(fDate.getDate())).slice(-2);
                var _dMonth = ('0'+(dDate.getMonth() + 1)).slice(-2);
                var _dDay = ('0'+(dDate.getDate())).slice(-2);
                date_output.push(_month+'/'+_day+'/'+fDate.getFullYear()+' - '+_dMonth+'/'+_dDay+'/'+dDate.getFullYear());
            });
            console.log(date_output);
            date_output.forEach(function(i) {
                $('.acf-field-repeater.acf-field-59f9a9d550a9b .acf-actions .acf-button').trigger('click');
                var tr = $('.acf-field-repeater.acf-field-59f9a9d550a9b table.acf-table tr:last').prev();
                tr.children('td:nth-child(2)').find('input').val(i);
                tr.children('td:nth-child(3)').find('input').val(price);
                tr.children('td:nth-child(4)').find('input').val(discount);
                tr.children('td:nth-child(5)').find('select').val(status);
            });
            $('#generate-trip-days, #generate-trip-months, #generate-trip-year, #default-departure-price, #default-departure-discount, #default-departure-status').val('');
        }
        i.removeClass('disable-click');
    });

// ------------------------------ date picker feature, auto price and discount ---------------------------
    $(".acf-actions.acf-hl a").attr("id", "btn-add");

    // --------------------------- for date-picker ------------------------------
    $(document).on("focus", ".acf-field-59f9a9d550a9b table.acf-table td.static-date input", function (event) {
        $(this).daterangepicker();
    });
 
    
//new code for new post type 
//change the title
console.log('working');
 jQuery('#acf-field_59f9aba409d86').on('change',function(){
  var title=jQuery(this).val();
    console.log(title);
    jQuery('#titlewrap #title').val(title);
    });
});



