jQuery(function ($) {

    $('#sendGuestTicketBTN').click(function () {
        $(this).blur();
        $(this).addClass('btn-secondary').removeClass('btn-outline-secondary');
        $('#trackGuestTicketBTN').addClass('btn-outline-secondary').removeClass('btn-secondary');
        $('#trackGuestTicketSection').hide();
        $('#sendGuestTicketSection').show();
        scrollTo('#sendGuestTicketSection');
    });

    $('#trackGuestTicketBTN').click(function () {
        $(this).blur();
        $(this).addClass('btn-secondary').removeClass('btn-outline-secondary');
        $('#sendGuestTicketBTN').addClass('btn-outline-secondary').removeClass('btn-secondary');
        $('#sendGuestTicketSection').hide();
        $('#trackGuestTicketSection').show();
        scrollTo('#trackGuestTicketSection');
    });

    $('.scrollToSearch').click(function(){
       scrollTo('header');
       $('.search-field').focus();
    });


    $('#sendGuestTicketForm').submit(function(e){
       e.preventDefault();
       var form = $(this),subBTN = form.find('button[type=submit]');
       form.css('opacity','.6');
       subBTN.attr('disabled', 'disabled');
       subBTN.html('<i class="fa fa-spinner fa-spin"></i>');
       setTimeout(function(){
           subBTN.html('ارسال شد!');
           form.css('opacity','1');
           $('#result').html('<div class="alert alert-success">تیکت با موفقیت ثبت شد.کدرهگیری تیکت : 2457987354</div>');
       },3000);
    });

    $('#trackGuestTicketForm').submit(function(e){
       e.preventDefault();
       var form = $(this),subBTN = form.find('button[type=submit]');
       form.css('opacity','.6');
       subBTN.attr('disabled', 'disabled');
       subBTN.html('<i class="fa fa-spinner fa-spin"></i>');
       setTimeout(function(){
           subBTN.html('رهگیری تیکت');
           form.css('opacity','1');
           $('#trackingResult').fadeIn();
       },3000);
    });

    $('.mobile-nav-toggle').click(function(){
        var btn = $(this);
        btn.siblings('ul').slideToggle();
    });

    function scrollTo(toELM){
        $('body,html').animate({
            scrollTop: $(toELM).offset().top + 'px'
        },{
            duration: 1000
        });
    }

});//doc