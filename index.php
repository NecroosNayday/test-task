<?php

	function createFile($fileName,$count){
		$file=fopen($fileName,"w");
		for ($i=0;$i<$count;$i++){
			fwrite($file,"ключ".$i."\t"."значение".$i."\x0A");
		}
	}

	function getTime($time = false)
	{
		return $time === false? microtime(true) : round(microtime(true) - $time, 3);
	}

	function binarySearch($fileName, $desiredValue)
	{
		$file=new SplFileObject($fileName);
		$start = 0;
		$end = sizeof(file($fileName)) - 1;

		while ($start <= $end) { 
			$position = floor(($start + $end) / 2);
			$file->seek($position);

			$elem = explode("\t", $file->current());
			$strnatcmp = strnatcmp($elem[0],$desiredValue); 

			if ($strnatcmp>0){
				$end = $position-1;
			}elseif($strnatcmp<0){
				$start = $position+1;
			}else{
				return $elem[1];
			}
		}
		return 'undef';
	}

	$fileName = "test.txt";
	$desiredValue=(isset($_POST['val']))? "ключ".$_POST['val']:"ключ500000";


	$checkFile = (file_exists(__DIR__."/$fileName"))?true:false;


	if($checkFile==false) createFile($fileName,2000000);

	if(isset($_POST['submit'],$_POST['val']) && !empty($_POST['val'])){
		$time=getTime();
		$result=binarySearch($fileName,$desiredValue);
		$time=getTime($time);
		$view = "</br> Поиск ключа - ".$result. "</br>" ."Времени затрачено - ".$time." секунд  ";
	}else{
		$view = " </br> Введите число в поле для ввода ";
	}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Бинарный поиск</title>
</head>
<body>
<div class="">

</div>

<form action="" method="post" class="" style="margin-top: 40px">
	<div class=""></div>
	<div class="">
		<div class="">
			<input type="text" name="val" autocomplete="off" placeholder="напишите число">
			<button class="" name="submit"> Найти </button>
		</div>
	</div>
	<div class=""></div>
</form>
<div class="">
	<div class=""></div>
	<div class="">
		<?=$view?>
	</div>
	<div class=""></div>
</div>

</body>
</html>



