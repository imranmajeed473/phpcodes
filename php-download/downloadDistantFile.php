<!-- 
Download large file from the web via php

https://gist.github.com/damienalexandre/1258787

-->
 <?php 
  /**
   * Download a large distant file to a local destination.
   *
   * This method is very memory efficient :-)
   * The file can be huge, PHP doesn't load it in memory.
   *
   * /!\ Warning, the return value is always true, you must use === to test the response type too.
   *
   * @author dalexandre
   * @param string $url
   *    The file to download
   * @param ressource $dest
   *    The local file path or ressource (file handler)
   * @return boolean true or the error message
   */
  public static function downloadDistantFile($url, $dest)
  {
    $options = array(
      CURLOPT_FILE => is_resource($dest) ? $dest : fopen($dest, 'w'),
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_URL => $url,
      CURLOPT_FAILONERROR => true, // HTTP code > 400 will throw curl error
    );

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $return = curl_exec($ch);

    if ($return === false)
    {
      return curl_error($ch);
    }
    else
    {
      return true;
    }
  }

 ?>