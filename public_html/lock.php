<?php

$lock=lock();
	$fp=fopen('C:\xampp\jsnr43\fuel\app\config/../files/ppt2.lock', "a");
	if(flock($fp, LOCK_EX | LOCK_NB)) {
		echo "B";
	}
	fclose($fp);

fclose($lock);

echo "A";

	function lock()
	{
		$lock = 'C:\xampp\jsnr43\fuel\app\config/../files/ppt.lock';

		if (!$fp=fopen($lock, "a")) die("can't lock");
		flock($fp, LOCK_EX);
		return $fp;
	}

	function lock2()
	{
		$lock = 'C:\xampp\jsnr43\fuel\app\config/../files/ppt2.lock';

		if (!$fp=fopen($lock, "a")) die("can't lock");
		flock($fp, LOCK_SH | LOCK_NB);
		return $fp;
	}