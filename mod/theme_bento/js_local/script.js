$(document).ready(function() {
  
  $('a.menuitemtools').click(function() {
    $('.submenuitemtools').insertAfter('#footer').show();
    $('.submenuitemtools').css('background', '#666').css({background: '#999', width: '200px', position: 'absolute', top: '0'}); // DEBUG
    
    return false;
  });
  
});
