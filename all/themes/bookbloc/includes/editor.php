<script type="text/javascript" src="/sites/all/modules/tinymce/tinymce/jscripts/tiny_mce/tiny_mce.js?p"></script>
<script type="text/javascript" src="/misc/collapse.js?p"></script>
<script type="text/javascript" src="/sites/all/themes/bookbloc/script.js?p"></script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
jQuery.extend(Drupal.settings, { "basePath": "/", "admin_menu": { "margin_top": 1 }, "user_relationships_ui": { "loadingimage": "/sites/all/modules/user_relationships/user_relationships_ui/images/loadingAnimation.gif" } });
//--><!]]>
</script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
function imceImageBrowser(fid, url, type, win) {win.open(Drupal.settings.basePath +'?q=imce&app=TinyMCE|url@'+ fid, '', 'width=760,height=560,resizable=1');}
//--><!]]>
</script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--

  function mceToggle(id, linkid) {
    element = document.getElementById(id);
    link = document.getElementById(linkid);
    img_assist = document.getElementById('img_assist-link-'+ id);

    if (tinyMCE.getEditorId(element.id) == null) {
      tinyMCE.addMCEControl(element, element.id);
      element.togg = 'on';
      link.innerHTML = 'disable rich-text';
      link.href = "javascript:mceToggle('" +id+ "', '" +linkid+ "');";
      if (img_assist)
        img_assist.innerHTML = '';
      link.blur();
    }
    else {
      tinyMCE.removeMCEControl(tinyMCE.getEditorId(element.id));
      element.togg = 'off';
      link.innerHTML = 'enable rich-text';
      link.href = "javascript:mceToggle('" +id+ "', '" +linkid+ "');";
      if (img_assist)
        img_assist.innerHTML = img_assist_default_link;
      link.blur();
    }
  }

//--><!]]>
</script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--

  tinyMCE.init({
    mode : "exact",
    theme : "simple",
    relative_urls : false,
    document_base_url : "/",
    language : "en",
    safari_warning : false,
    entity_encoding : "raw",
    verify_html : false,
    preformatted : false,
    convert_fonts_to_spans : true,
    remove_linebreaks : true,
    apply_source_formatting : true,
    theme_advanced_resize_horizontal : false,
    theme_advanced_resizing_use_cookie : false,
    plugins : "advhr,iespell,style",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_path_location : "bottom",
    theme_advanced_resizing : true,
    theme_advanced_blockformats : "p,address,pre,h1,h2,h3,h4,h5,h6",
    theme_advanced_buttons3 : "strikethrough,iespell",
    theme_advanced_buttons1 : "bold,italic,underline,separator,undo,separator,paste,separator,charmap",
    //theme_advanced_buttons2 : "formatselect,fontselect,fontsizeselect,separator,justifyleft,justifycenter,justifyright,separator,numlist,bullist,indent,outdent",
    //extended_valid_elements : "hr[class|width|size|noshade],img[class|src|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],a[name|href|target|title|onclick],img[class|src|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|obj|param|embed]",
    elements : "edit-comment",
    //file_browser_callback : "imceImageBrowser"
  });

//--><!]]>
</script>
