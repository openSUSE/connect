$(document).ready(function() {
  
  $('#subheader a.menuitemtools').click(function() {
    
    // get Menu-Item position X/Y
    var menuItemH = $(this).height();
    var menuPos = $('.menuitemtools').offset();
    var menuPosY = parseInt(menuPos.top) + menuItemH;
    var menuPosX = parseInt(menuPos.left) - 10; // dropdown content has 10px margin.
    
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
  
  
  // == Membership Request Page ==
  
  // TODO: the comment getting could be moved into a singel function
  // function getComment (argument) {
  //   ...
  // }
  
  // TODO: disable 
  
  
  
  $('a.vote-up').click(function() {
    var id = $(this).attr('id').replace('voteup_', 'vote-comment_')
    var comment = $('input#' + id).val();
    var url = $(this).attr('href');
    var urlNew = url.replace('reason', comment);
    
    $(this).attr('href', urlNew);
    
    // DEBUG
    // console.log('vote-up' + ' url ' + url + ' val: ' + $('input#vote-comment').val());
    // alert($(this).attr('href'));
    
    return true;
  });

  $('a.vote-dn').click(function() {
    var id = $(this).attr('id').replace('votedn_', 'vote-comment_')
    var comment = $('input#' + id).val();
    var url = $(this).attr('href');
    var urlNew = url.replace('reason', comment);
    
    $(this).attr('href', urlNew);
    
    // DEBUG
    // console.log('vote-up' + ' url ' + url + ' val: ' + $('input#vote-comment').val());
    // alert($(this).attr('href'));
    
    return true;
  });
  

});
