//Toggle Overlay
$(document).on('click', '.dropdown-btn',  function(){
    $('.burger-icon').toggleClass('burger-menu-active');
    togglePrimaryMenu();
    setTimeout(function(){
        $('.header-wrapper').toggleClass('header-wrapper-collapsing');
        $('.header-el-wrapper').toggleClass('header-el-collapsing');
    }, 500);
});

$(document).on('click', '.search-btn-toggle', function () {
    if($('.search-toggle-modal').hasClass('search-toggle-modal-shown')){
        resetTitle();
        $('.search-toggle-modal').removeClass('search-toggle-modal-shown');
    } else{
        setTitle('Search');
        $('.search-toggle-modal').addClass('search-toggle-modal-shown');
    }
    toggleHamburgerSwitch();
    $('.header-right-btn-wrapper').toggleClass('d-none');
});

$(document).on('submit','.rGf',function(e){
    e.preventDefault();
    var t=$(this);
    $.ajax({
        url: t.attr('action'),
        method: t.attr('method'),
        data: t.serialize(),
        success: function(d){
            var tmpl = $.templates('#sRBar');
            $('.search-result-container').html(tmpl.render(d));
        }
    })
});

function togglePrimaryMenu(){
    $('.link-container').toggleClass('link-container-shown');
    $('.header-el-wrapper').toggleClass('header-el-wrapper-expanded').toggleClass('header-el-collapsing');
    $('.header-wrapper').toggleClass('header-wrapper-expanded').toggleClass('header-wrapper-collapsing');
}

function toggleHamburgerSwitch() {
    $('.dropdown-btn').toggleClass('d-none');
}

function setTitle(name, link){
    link = link || '#';
    $('.title-name').text(name).attr('href', link);
}
function resetTitle(){
    $('.title-name').text('Labstry Forum').attr('href', '/forum');
}
$(window).ready(function(){
    set100vh();
});
$(window).on('resize', function(){
    set100vh();
})
function set100vh(){
    $('.real-vh-100').height($(window).innerHeight());
    $('.real-vh-min-100').css('min-height', $(window).innerHeight() + 'px');
}
