$('.menu-control--btn button').click(function () {
    let btnId = $(this).attr('id');    
    if($(this).hasClass('is-open')) {
        $(this).removeClass('is-open');
        if('btn-menu' == btnId) {
            $('#menu__box').removeClass('is-open');
        } else {
            $('.header-nav-parts').removeClass('is-open');
        }
    } else {
        $('.is-open').removeClass('is-open');
        $(this).addClass('is-open');   
        if('btn-menu' != btnId) {
            $('#menu__box').removeClass('is-open');
            $('.header-nav-parts').addClass('is-open');;
        };
        if('btn-menu' == btnId) {
            $('.header-nav-parts').removeClass('is-open');
            $('#menu__box').addClass('is-open');;
        };
    }
})


/**
 * メニューをクリックすると、該当の場所へ移動します。
 * クリックしたらメニューは折りたたむ。
 */
$('.menu-of-menu-hambuger').click(function () {
    if($(this).hasClass('is-open')) {
        $(this).removeClass('is-open')
        $('.menu-control--btn-menu').removeClass('is-open')
    }
})

// 新卒採
$('#btn-entry-new').click(function () {
    if($(this).hasClass('is-open')) {
        removeMenuSecond();
        $(this).removeClass('is-open')
    } else {
        showMenuNew($(this))
    }    
})

function removeMenuSecond() {
    $('#btn-entry-car').removeClass('is-open');
    $('.menu-entry-item-sub-list.is-open').removeClass('is-open');
    $('#menu-entry-item-sub-list-second').removeClass('is-open');
    $('#menu-entry-car-child').find('.is-open').removeClass('is-open');
}

function showMenuNew(el) {   
    removeMenuSecond();
    if($('#menu-entry-new-child').hasClass('is-open')) {
            $('#menu-entry-new-child').removeClass('is-open');
            $(el).removeClass('is-open');
    } else {
        $('#menu-entry-new-child').addClass('is-open');
        $(el).addClass('is-open');
    }
}

function removeMenuNew() {
    $('#btn-entry-new').removeClass('is-open');
    $('.menu-entry-item-sub-list.is-open').removeClass('is-open');
    $('#menu-entry-new-child').removeClass('is-open');
    $('#menu-entry-new-child').find('.is-open').removeClass('is-open');
}

function showMenuSecond(el) {
    removeMenuNew();
    if($('#menu-entry-car-child').hasClass('is-open')) {
            $('#menu-entry-car-child').removeClass('is-open');
            $(el).removeClass('is-open');
    } else {
        $('#menu-entry-car-child').addClass('is-open');
         $(el).addClass('is-open');
    }
}

// 
$('#btn-entry-car').click(function () { 
    if($(this).hasClass('is-open')) {
        removeMenuSecond();
        $(this).removeClass('is-open')
    } else {
        showMenuSecond($(this))
    } 
})

// level 1
$('li.menu-level-1>a').click(function () {
    if(!$(this).hasClass('is-open')) {  
        $(this).parent().siblings().removeClass('is-open');
        $(this).parent().siblings().find('.is-open').removeClass('is-open');
        $(this).parent().addClass('is-open'); 
        $(this).addClass('is-open');
    } else {
        $(this).parent().removeClass('is-open');        
        $(this).parent().find('.is-open').removeClass('is-open');
        $(this).removeClass('is-open');       
        $(this).parent().siblings().removeClass('is-open');
    }
})

// level 2
$('ul.menu-level-2>li>a').click(function () {
    $(this).parent().siblings().removeClass('is-open');
    $(this).parent().siblings().find('.is-open').removeClass('is-open'); 
    if(!$(this).hasClass('is-open')) {
        $(this).parent().addClass('is-open'); 
        $(this).parent().find('ul').addClass('is-open'); 
        $(this).addClass('is-open');
    } else {   
        $(this).parent().removeClass('is-open'); 
        $(this).parent().find('ul').removeClass('is-open'); 
        $(this).removeClass('is-open');       
    }
})

$('.btn-menu-control').click(function () {
    $(this).siblings().removeClass('is-open');
    $(this).parent().siblings().removeClass('is-open');
    $(this).parent().siblings().find('.is-open').removeClass('is-open'); 
    if($(this).hasClass('is-open')) {
        $(this).parent().removeClass('is-open'); 
        $(this).parent().find('.is-open').removeClass('is-open'); 
        $(this).removeClass('is-open');        
        $(this).parent().parent().removeClass('min-height-260');
    } else {
        $(this).addClass('is-open')
        let btn_id = $(this).attr('id');
        let btn_arr = btn_id.split('-');
        let menu_cnt = btn_arr[btn_arr.length - 1];
        let removeElement = '#menu-entry-item-sub-list-second-'+menu_cnt;
        let addElement = '#menu-entry-item-sub-list-first-'+menu_cnt;
        if(!btn_id.includes('new')) {
            addElement = '#menu-entry-item-sub-list-second-'+menu_cnt;
            removeElement = '#menu-entry-item-sub-list-first-'+menu_cnt;
        }
        $(removeElement).removeClass('is-open');
        $(addElement).addClass('is-open');
        $('.btn-menu-control.bg-open-button').removeClass('bg-open-button');
        $(this).addClass('bg-open-button');
        $(this).parent().parent().addClass('min-height-260');
    }    
})
// TOP BUTTOB
// Get the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    $('.menu-control--btn').addClass('is-scroll');
    $('#btn_go_to_top').show();
  } else {
    $('#btn_go_to_top').hide();
    $('.menu-control--btn').removeClass('is-scroll');
  }
}

function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}