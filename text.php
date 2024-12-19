<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->set('test','Dilshod');
$redis->set('text1','mahmud');
echo $redis->get('test');
echo "</br>";
echo $redis->get('text1');
