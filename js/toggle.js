//A toggle script for opening the primary menu

//define
var mobile_max = 767;
var tablet_min = 768;
var tablet_max = 991.98;
var desktop_min = 992;


//Toggle Overlay
$(document).on('click', '.dropdown-btn',  function(){
    if($('.burger-icon').hasClass('burger-menu-active')){
        $('.burger-icon').removeClass("burger-menu-active");
    }else{
        $('.burger-icon').addClass("burger-menu-active");
    }
    togglePrimaryMenu();
    toggleSearchOverlay();
});
$(document).on('click', '.search-div-btn', function(){
    toggleSearchOverlay();
    togglePrimaryMenu();
    if(!isInSearchMode()){
        enterSearchMode();
    }else{
        leaveSearchMode();
    }
})

//Toggle Hamburger Menu on or off
$('.search-input').on('focusin', function(){
    enterSearchMode();
});
$('.header-search-close-btn').on('click', function(){
    leaveSearchMode();
    $('.search-result-provider').html("");
    $('.search-input').val("");
})


function togglePrimaryMenu(){
    $('.header-link-wrapper').toggleClass('primary-menu-show');
}
function toggleSearchOverlay() {
    if($(".toggle-search-overlay").hasClass('active')){
        $(".toggle-search-overlay").removeClass('active');
        $('.general-header-content-wrapper').removeClass('general-link-active');
        $('.under-hamburger-layer').toggleClass('under-hamburger-layer-active');
        $('body').removeClass("modal-open");
        $('.header-link').removeClass("link-hidden");
    }else{
        $(".toggle-search-overlay").addClass('active');
        $('.general-header-content-wrapper').addClass('general-link-active');
        $('.under-hamburger-layer').toggleClass('under-hamburger-layer-active');
        $('body').addClass("modal-open");
        $('.header-link').addClass("link-hidden");
    }
    isSearchToggled = !isSearchToggled;
}

function enterSearchMode(){
    if(window.matchMedia("(min-width: "+ desktop_min+ "px)").matches) {
        //lg mode
        $('.link-wrapper').addClass('deactivate');
        $('.header-wrapper').addClass('header-expanded');
    }else{
        $('.hamburger-layer').addClass('deactivate');
        $('.header-search-close-btn').addClass('header-search-close-btn-shown')

    }
}
function isInSearchMode(){
    return $('.link-wrapper').hasClass('deactivate') || $('.hamburger-layer').hasClass('deactivate');
}

function leaveSearchMode() {
    if(window.matchMedia("(min-width: "+ desktop_min+ "px)").matches) {
        //lg mode
        $('.link-wrapper').removeClass('deactivate');
        $('.header-wrapper').removeClass('header-expanded');
    }else{
        $('.hamburger-layer').removeClass('deactivate');
        $('.header-search-close-btn').removeClass('header-search-close-btn-shown')
    }


}