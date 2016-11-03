<?php
		$source_url = 'http://www.alibaba.com';
		$url = 'https://www.linkedin.com/countserv/count/share?url='.$source_url.'&format=json';
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$cont = curl_exec($ch);
		$json = json_decode($cont, true);
		echo isset($json['count'])?intval($json['count']):0;
?>
