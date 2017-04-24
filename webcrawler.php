<?php
	/**
	 reference: http://php.net/manual/en/ref.curl.php
	*/
	
	function getRquest($url)
	{
	 	// create a new cURL resource
	 	$ch = curl_init();
		    
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		    
		// grab URL and pass it to the browser
		$output = curl_exec($ch);
		    
		// close cURL resource, and free up system resources
		curl_close($ch);
		
		return $output;
	}


	/**
	 *
	 *
	 * @param string $web_content
	 * @return array
	 */
	function filterUrl($web_content)
	{
	    $reg_tag_a = '/<[a|A].*?class="postTitle2".*?href=[\'\"]{0,1}([^>\'\"\ ]*).*?>/';
	    $result = preg_match_all($reg_tag_a, $web_content, $match_result);
	    if ($result) {
	        return $match_result[1];
	    }
	}
	
	/**
	 * 
	 *
	 * @param string $content
	 * @return array
	 */
	function filterContent($content)
	{
	
	    $reg = '/<.*\"cnblogs_post_body\">(.*?)<\/div>/ism';
	    $result = preg_match_all($reg, $content, $match_result);
	    if ($result) {
	        return $match_result[1];
	    }
	}
	
	/**
	 *
	 *
	 * @param string $fileName
	 * @param string $contents
	 */
	function writeToFile($fileName, $contents)
	{
	    $fp = fopen($fileName, 'w');
	
	    fwrite($fp, $contents);
	    fclose($fp);
	}
	
	$output = getRquest("http://www.cnblogs.com/freephp");
	
	$articleUrls = filterUrl($output);
	
	if (empty($articleUrls)) {
	    echo 'Obtain url failed';
	    die();
	}
	
	$articleNum = count($articleUrls); 
	echo 'total number of articles are:', $articleNum, "<br/>";
	
	foreach ($articleUrls as $url) {
	    echo 'start to crawl url:', $url, "<br/>";
	    $out = getRquest($url);
	    $cont = filterContent($out);
	    $filename = str_replace('.html', '', str_replace('http://www.cnblogs.com/freephp/p/', '', $url));
	    writeToFile($filename . '.txt', $cont[0]);
	    echo 'finish crawling url:', $url, "<br/>";
	}
?>