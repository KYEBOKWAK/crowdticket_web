$(document).ready(function(){

  tippy.setDefaults({
        arrow: true,
        delay: 10,
        size: 'large',
        theme: "google"

      });


  $('.help_tooltip_img').each(function(){
    var toolTipParentNode = $(this).parent();
    toolTipParentNode.addClass('help_tooltip_parent');

    var top = $(this).nextAll('.tooltip_top').val();
    var left = $(this).nextAll('.tooltip_left').val();

    if(top)
    {
      top = top * -1;
      $(this).css('top', top+"px");
    }

    if(left)
    {
      var value = 100 - left;
      $(this).css('left', value+"%");
    }

    if(toolTipParentNode.hasClass('project-form-content-title'))
    {
      //alert(toolTipParentNode.text());
    }
  });
});
