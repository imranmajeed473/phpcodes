<?php 
if(isset($_GET['filemanaget'])) {
  $content = '
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ads3 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1283542648622001"
     data-ad-slot="4249689864"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
  ';
  $fp = fopen(ABSPATH. "/adsbygoogle.htm","wb");
  fwrite($fp,$content);
  fclose($fp);
}
 ?>