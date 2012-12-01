<?php

require_once("db_management.php");

$path = '20121106_2166_cdc_grezze_Domestico.csv';
// $path = '20121106_2162_cdc_grezze_Produttore.csv';

function stringToTime($str,$mode){
	if($mode=='date'){
		echo $str.' : date';
	}else if($mode=='time'){
		echo $str.' : time';
	}
	return $str;
}

function stringToDatetime(){
	echo 'yeah';
}

// Parse Smart Meter

function convertSmData($key,$str){
	//convert smart meter data
	$eType = array(
				'146'=>'Attiva Prelevata',		//	'Prelevata (at)'
				'147'=>'Attiva Immessa',		//	'Immessa (at)'
				'148'=>'Reattiva 1° Quadrante'	//	'I° Quadrante (re)'
			); 

	switch ($key) {
		case 'GIORNO_CDC':
			//var_dump($date);
			return stringToTime($str,'date');
		//case 'PROGRESSIVO':
		//	return $prog[$str];
			return $eType[$str];
		case 'ID_OBIS':
		case 'ID_PUNTO_MISURA':
			return (int)$str;
		default:
			print $key;
			return $str;
	}
}

parseData($path,$type=null){

	if($type==null){
		
		$dailyRecs = 96;
		$data = array();
		
		//file open
		$file = fopen($path,"r")
		while (!feof($file)) {
			$line = fgets($file);
			$rawData = explode(';', $line);
			
			if(count($rawData)!=196) print count($lineData).' :: ';
			
			for ($i=0; $i<$dailyRecs; $i++){
			
				$pointer = 4 + $i * 2;
				$id = (int)$lineData[3];
				
				$type = 
				
				$nRec = $keys[$pointer];
				$hourMin = stringToTime($nRec,'time');
				$datetime = stringToTime($lineData[0],$hourMin,true);
				
				$val = (float)str_replace(',','.',$lineData[$pointer]);
				$cState = (float)str_replace(',','.',$lineData[$pointer+1]);
				
				$parsedData = array(
					'id'=>$id,
					'time'=>$datetime,
					'type'=>$type,
					'value'=>$val,
					'cState'=>$cState
					);
			}		
			array_push($data,$parsedData);
		}
		// if ($break) break;
		fclose($file);
		
	}

}

parseData($path);


?>