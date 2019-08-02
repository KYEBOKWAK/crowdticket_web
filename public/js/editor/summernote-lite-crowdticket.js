$(document).ready(function() {
  var isColorChange = true;
  var editorAjaxOption = {
    'beforeSerialize': function($form, options) {
    },
    'success': function(result) {
      $('#editor_image').val('');
      $("#editor_image_name").val('');

      $('#summernote').summernote('insertImage', result, function ($image){
        $image.css('width', "100%");
      });
    },
    'error': function(data) {
      alert("이미지 업로드에 실패하였습니다." + JSON.stringify(data));
      $('#editor_image').val('');
      $("#editor_image_name").val('');
    }
  };

  var sendFile = function(file, editor, welEditable) {
      var reader = new FileReader();
      reader.onload = function(e) {
        //alert("onload: " + e.target.result);
        //$('#summernote').summernote("insertNode", e.target.result);
        $('#editor_image').val(e.target.result);
        $("#editor_image_name").val(getRemoveExpWord(file.name));
        $("#editor_image_set_form").submit();
      };
      reader.readAsDataURL(file);

      //editorImageInputFile.val(file);
  };

  var customHighlight = function (context) {
  var ui = context.ui;
  // create button
  var button = ui.button({
      contents: '<i class="editor_button_loading"/>',
      click: function () {
      }
    });

    return button.render();   // return button as jquery object
  };

  $('#summernote').summernote({
    tabsize: 4,
    //width: 790,
    height: 500,
    disableDragAndDrop: false,

    toolbar: [
    // [groupName, [list of button]]
    ['fontname', ['fontname']],
    ['style', ['bold', 'strikethrough']],
    ['font', []],
    //['fontfamily', ['Noto Sans KR']],
    ['insert', ['link', 'picture', 'video']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['paragraph']],
    ['height', ['height']],
    ['customHighlight', ['customHighlight']],
    //['customUnderLine', ['customUnderLine']],
  ],

    fontNames: ['Noto Sans KR'],
    fontSizes: ['12', '16', '20', '28'],
    colors: [
              ['#000000', '#424242', '#636363', '#9C9C94', '#CEC6CE', '#EFEFEF', '#F7F7F7', '#FFFFFF'],
              ['#43c9f0'],
          ],

    colorsName: [
              ['Black', 'Tundora', 'Dove Gray', 'Star Dust', 'Pale Slate', 'Gallery', 'Alabaster', 'White'],
              ['PointColor'],
          ],

    lineHeights: ['2.0'],

    buttons: {
      customHighlight: customHighlight,
    //  customUnderLine: customUnderLine
    },

    callbacks: {
      onImageUpload: function(files, editor, welEditable){
        loadingProcessWithSize($('.editor_button_loading'), 20, 20);
          for (var i = files.length - 1; i >= 0; i--) {
            if(isFileCheckFromEditor(files[i]) == true){
              sendFile(files[i], editor, welEditable);
            }
            else
            {
              loadingProcessStopWithSize($('.editor_button_loading'));
            }
          }
        },
        onChange: function(contents, $editable) {
          if(isColorChange)
          {
            font_to_span();
            isColorChange = false;
          }
        },
        /*
        onPaste: function(e) {
          //console.error('Called event paste : ' + e.context);
          var thisNote = $(this);
            var updatePastedText = function(){
                var original = $('#summernote').summernote('code');
                var cleaned = CleanPastedHTML(original); //this is where to call whatever clean function you want. I have mine in a different file, called CleanPastedHTML.
                //$('#summernote').summernote('insertText').html(cleaned); //this sets the displayed content editor to the cleaned pasted code.
                $('#summernote').summernote('code', cleaned); //this sets the displayed content editor to the cleaned pasted code.
            };
            setTimeout(function () {
                //this kinda sucks, but if you don't do a setTimeout,
                //the function is called before the text is really pasted.
                updatePastedText();
            }, 5);

        }
        */
      }
  });

  $('#editor_image_set_form').ajaxForm(editorAjaxOption);

  if($('#tx_load_content').val())
  {
    var markupStr = $('#tx_load_content').val();

    $('#summernote').summernote('code', markupStr);
  }

  $('#summernote').summernote('fontSize', 16);
  $('#summernote').summernote('lineHeight', 2.0);

  $('.note-current-color-button').click(function(){
    isColorChange = true;
  });

  $('.note-color-btn').click(function(){
    isColorChange = true;
  });
});

function getSelectedNode()
{
    if (document.selection)
        return document.selection.createRange().parentElement();
    else
    {
        var selection = window.getSelection();
        if (selection.rangeCount > 0)
            return selection.getRangeAt(0).startContainer.parentNode;
    }
}

function getSelectionHtml() {
    var htmlContent = ''

    // IE
    if ($.browser.msie) {
        htmlContent = document.selection.createRange().htmlText;
    } else {
        var range = window.getSelection().getRangeAt(0);
        var content = range.cloneContents();

        $('body').append('<span id="selection_html_placeholder"></span>');
        var placeholder = document.getElementById('selection_html_placeholder');

        placeholder.appendChild(content);

        htmlContent = placeholder.innerHTML;
        $('#selection_html_placeholder').remove();

    }


    return htmlContent;
}

function font_to_span() {
  $container = $('.note-editable');
  $font = $container.find('font');
  font_Color = $font.attr('color');
  font_bgColor = $font.css('background-color');
  $font.replaceWith(function() {
    return $("<span />", {
      html: $(this).html(),
      style: 'color:' + font_Color + ';'+'background-color: '+font_bgColor+';'
    });
  });
}

function CleanPastedHTML(input) {
  // 1. remove line breaks / Mso classes
  var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g;
  var output = input.replace(stringStripper, ' ');
  // 2. strip Word generated HTML comments
  var commentSripper = new RegExp('<!--(.*?)-->','g');
  var output = output.replace(commentSripper, '');
  var tagStripper = new RegExp('<(/)*(meta|link|span|i|u|b|\\?xml:|st1:|o:|font)(.*?)>','gi');
  // 3. remove tags leave content if any
  output = output.replace(tagStripper, '');
  // 4. Remove everything in between and including tags '<style(.)style(.)>'
  var badTags = ['style', 'script','applet','embed','noframes','noscript'];

  for (var i=0; i< badTags.length; i++) {
    tagStripper = new RegExp('<'+badTags[i]+'.*?'+badTags[i]+'(.*?)>', 'gi');
    output = output.replace(tagStripper, '');
  }
  // 5. remove attributes ' style="..."'
  var badAttributes = ['style', 'start'];
  for (var i=0; i< badAttributes.length; i++) {
    var attributeStripper = new RegExp(' ' + badAttributes[i] + '="(.*?)"','gi');
    //if(badAttributes[i] == 'style')
    {
      output = output.replace(attributeStripper, " style='font-size:16px;line-height: 2.0;'");
    }
    //else
    {
    //  output = output.replace(attributeStripper, '');
    }
  }
  return output;
}
