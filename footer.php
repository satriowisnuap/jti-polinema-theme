<?php
get_template_part(
  'template-parts/layout/footer'
);

get_template_part(
  'template-parts/components/video-modal'
);

get_template_part(
  'template-parts/components/mahasiswa-modal'
);

get_template_part(
  'template-parts/components/dosen-modal'
);

wp_footer();
?>

<!-- Google Translate Widget for Automatic Translation -->
<div id="google_translate_element" style="display:none;"></div>
<script type="text/javascript">

  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'id', 
      includedLanguages: 'en,id', 
      autoDisplay: false
    }, 'google_translate_element');
  }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<style>
  /* Hide Google Translate top banner, tooltips, and widget UI */
  .goog-te-banner-frame.skiptranslate, .goog-te-gadget-icon, .skiptranslate > iframe { display: none !important; }
  body { top: 0px !important; }
  .goog-tooltip { display: none !important; }
  .goog-tooltip:hover { display: none !important; }
  .goog-text-highlight { background-color: transparent !important; border: none !important; box-shadow: none !important; }
  #goog-gt-tt { display: none !important; }
</style>

</body>
</html>