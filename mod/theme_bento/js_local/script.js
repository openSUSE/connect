$(document).ready(function() {
  
  $('#subheader a.menuitemtools').click(function() {
    
    // get Menu-Item position X/Y
    var menuItemH = $(this).height();
    var menuPos = $('.menuitemtools').offset();
    var menuPosY = parseInt(menuPos.top) + menuItemH;
    var menuPosX = parseInt(menuPos.left);
    
    $('.submenuitemtools').insertAfter('#footer').css({
        top: menuPosY,
        left: menuPosX
        }).slideDown('fast');
    return false;
  });
  
  $('.submenuitemtools').mouseleave(function() {
    slideupFast('.submenuitemtools');
  });
  
  function slideupFast (e) {
    $(e).slideUp('fast');
    return true;
  }
  
});
