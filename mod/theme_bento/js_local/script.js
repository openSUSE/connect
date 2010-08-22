$(document).ready(function() {
  
  $('#subheader a.menuitemtools').click(function() {
    
    // get Menu-Item position X/Y
    var menuItemH = $(this).height();
    
    var menuPos = $('.menuitemtools').offset();
    var menuPosY = parseInt(menuPos.top) + menuItemH;
    var menuPosX = parseInt(menuPos.left);

    console.log(menuPosX + " " + menuPosY); // DEBUG
    
    $('.submenuitemtools').insertAfter('#footer').css({
        top: menuPosY,
        left: menuPosX
        }).show();
    
    return false;
  });
  
  $('.submenuitemtools').mouseleave(function() {
    $('.submenuitemtools').hide();
  });
  
  
});
