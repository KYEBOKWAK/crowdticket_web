$(document).ready(function(){

  tippy.setDefaults({
        arrow: true,
        delay: 10,
        size: 'large',
        theme: "google"

      });


  $('.help_tooltip_img').each(function(){
    var toolTipParentNode = $(this).parents();
    toolTipParentNode.addClass('help_tooltip_parent');
  });
});
