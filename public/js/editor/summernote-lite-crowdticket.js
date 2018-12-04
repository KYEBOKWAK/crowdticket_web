$(document).ready(function() {
  var editorAjaxOption = {
    'beforeSerialize': function($form, options) {
    },
    'success': function(result) {
      $('#editor_image').val('');
      $("#editor_image_name").val('');

      $('#summernote').summernote('insertImage', result);
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
      contents: '<i class="note-icon-font note-recent-color" style="background-color: #EF4D5D; color: white;"/> 강조하기',
      tooltip: 'hellobb',
      click: function () {
        // invoke insertText method with 'hello' on editor module.
        //context.invoke('backColor', '#EF4D5D');
        //context.invoke('foreColor', 'white');
        //$('#summernote').summernote('editor.removeFormat');
        //$("#summernote").code().replace(/<\/?[^>]+(>|$)/g, "");
        //var selectedOri = window.getSelection().getRangeAt(0);

        //var selectedParentNode = getSelectedNode();
        //selectedParentNode.style.background="";

        //var selected = getSelectedNode();
        //var selectedHtml = getSelectionHtml();
        //var parentNode = selected.parentElement();
        //alert(selected.style.background);
        //if(selected.search("linear-gradient") >= 0)
        //{
          //alert(selected.search("linear-gradient"));
        //}
        //var repselected = selected.replace("background: linear-gradient(0deg, rgb(239, 77, 93) 30%, white 0%);", "");

        //var node = document.createElement('span');
        //node.innerHTML = repselected;

        //selectedOri.deleteContents();
        //selectedOri.insertNode(node);
        //alert(selected);

      }
    });

    return button.render();   // return button as jquery object
  };

  //customUnderLine
  var customUnderLine = function (context) {
  var ui = context.ui;
  // create button
  var button = ui.button({
      contents: '<i class="note-icon-font note-recent-color" style="background-color: white; color: black; border-bottom: 2px solid #EF4D5D;"/> 밑줄긋기',
      tooltip: '',
      click: function () {
      }
    });

    return button.render();   // return button as jquery object
  };

  $('#summernote').summernote({
    tabsize: 4,
    height: 1000,
    width: 790,
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
    //['customHighlight', ['customHighlight']],
    //['customUnderLine', ['customUnderLine']],
  ],

    fontNames: ['Noto Sans KR'],
    fontSizes: ['10', '16', '18'],
    colors: [
              ['#000000', '#424242', '#636363', '#9C9C94', '#CEC6CE', '#EFEFEF', '#F7F7F7', '#FFFFFF'],
              ['#EF4D5D'],
          ],

    colorsName: [
              ['Black', 'Tundora', 'Dove Gray', 'Star Dust', 'Pale Slate', 'Gallery', 'Alabaster', 'White'],
              ['Red', 'Orange Peel', 'Yellow', 'Green', 'Cyan', 'Blue', 'Electric Violet', 'Magenta'],
              ['Azalea', 'Karry', 'Egg White', 'Zanah', 'Botticelli', 'Tropical Blue', 'Mischka', 'Twilight'],
              ['Tonys Pink', 'Peach Orange', 'Cream Brulee', 'Sprout', 'Casper', 'Perano', 'Cold Purple', 'Careys Pink'],
              ['Mandy', 'Rajah', 'Dandelion', 'Olivine', 'Gulf Stream', 'Viking', 'Blue Marguerite', 'Puce'],
              ['Guardsman Red', 'Fire Bush', 'Golden Dream', 'Chelsea Cucumber', 'Smalt Blue', 'Boston Blue', 'Butterfly Bush', 'Cadillac'],
              ['Sangria', 'Mai Tai', 'Buddha Gold', 'Forest Green', 'Eden', 'Venice Blue', 'Meteorite', 'Claret'],
              ['Rosewood', 'Cinnamon', 'Olive', 'Parsley', 'Tiber', 'Midnight Blue', 'Valentino', 'Loulou']
          ],

    buttons: {
      customHighlight: customHighlight,
      customUnderLine: customUnderLine
    },

    callbacks: {
      onImageUpload: function(files, editor, welEditable){
          for (var i = files.length - 1; i >= 0; i--) {
            sendFile(files[i], editor, welEditable);
          }
        }
      }
  });

  $('#editor_image_set_form').ajaxForm(editorAjaxOption);

  if($('#tx_load_content').val())
  {
    var markupStr = $('#tx_load_content').val();

    $('#summernote').summernote('code', markupStr);
  }

  $('#summernote').summernote('fontSize', 16);
  //$('#summernote').summernote('backColor', "#EF4D5D");
});
/*
function getSelectionHtml() {
    var html = "";
    if (typeof window.getSelection != "undefined") {
        var sel = window.getSelection();
        if (sel.rangeCount) {
            var container = document.createElement("div");
            for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                container.appendChild(sel.getRangeAt(i).cloneContents());
            }
            html = container.innerHTML;
        }
    } else if (typeof document.selection != "undefined") {
        if (document.selection.type == "Text") {
            html = document.selection.createRange().htmlText;
        }
    }
    return html;
}
*/

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
