<?php
ini_set('memory_limit','1900M');
$file = file_get_contents('./testResults.txt');

$file = simplexml_load_string($file);
$file = json_decode(json_encode((array)$file),1);

$dataSet = [];
$percentiles = [];

//$fp = fopen('./tests/JMeter/formatedResults.csv', 'w+');
//$string = "{$datetime},{$hr['@attributes']['t']},{$serverTime}\n";
//fwrite($fp, $string);

foreach ($file['httpSample'] as $key => $hr) {
    $hr['responseData'] = (array)json_decode($hr['responseData']);
    $time = round(($hr['@attributes']['ts']/1000)/ 120) * 120;
    $datetime = date('H:i:s', $time);

    if (!isset($dataSet[$datetime])) {
        $dataSet[$datetime] = [];
    }

    if (!isset($percentiles[$datetime])) {
        $percentiles[$datetime] = [];
    }

    $serverTime = round($hr['responseData']['timestamp'] * 1000, 0);

    $dataSet[$datetime][] = ['rt' => (int)$hr['@attributes']['t'], 'st' => (int)$serverTime];
    unset($file['httpSample'][$key]);
}

function get_percentile($percentile, $array) {
    sort($array);
    $index = ($percentile/100) * count($array);
    if (floor($index) == $index) {
        $result = ($array[$index-1] + $array[$index])/2;
    }
    else {
        $result = $array[floor($index)];
    }
    return $result;
}

foreach ($dataSet as $date => $dataSetRow) {

    $count = count($dataSetRow);
    $percentiles[$date]['count'] = $count;

    $rtArray = [];
    $stArray = [];
    foreach ($dataSetRow as $dataRow) {
        $rtArray[] = $dataRow['rt'];
        $stArray[] = $dataRow['st'];
    }

    $rtArray = array_values($rtArray);
    $stArray = array_values($stArray);

//    var_dump($dataSetRow, $count, $count50, $count90, $count95, $count99);die;
    $percentiles[$date]['rt50'] = get_percentile(50, $rtArray);
    $percentiles[$date]['rt90'] = get_percentile(90, $rtArray);
    $percentiles[$date]['rt95'] = get_percentile(95, $rtArray);
    $percentiles[$date]['rt99'] = get_percentile(99, $rtArray);
    $percentiles[$date]['st50'] = get_percentile(50, $stArray);
    $percentiles[$date]['st90'] = get_percentile(90, $stArray);
    $percentiles[$date]['st95'] = get_percentile(95, $stArray);
    $percentiles[$date]['st99'] = get_percentile(99, $stArray);
}

$fp = fopen('./formatedResults.csv', 'w+');
foreach ($percentiles as $date => $row) {
    $string = "{$date},{$row['rt50']},{$row['rt90']},{$row['rt95']},{$row['rt99']},{$row['st50']},{$row['st90']},{$row['st95']},{$row['st99']}\n";
    fwrite($fp, $string);
}
fclose($fp);

//print_r($arr);