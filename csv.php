<?php
require_once('SimpleExcel/SimpleExcel.php'); // load the main class file (if you're not using autoloader)
use SimpleExcel\SimpleExcel;

/*$myHeaders = Array('a', 'b');
$myData = Array(Array('c', 'd'), Array('e', 'f'));

$csvName = 'temp.csv';

$fp = fopen($csvName, 'w');
fputcsv($fp, $myHeaders);
foreach ($myData as $line) {
    fputcsv($fp, $line);
}
fclose($fp);

// now send to browser if this is a web request
$csvData = file_get_contents($csvName);
header('Content-Type: application/vnd.ms-excel');
header('Content-Length: ' . strlen($csvData));
echo $csvData;*/



$excel = new SimpleExcel('xml');

$excel->writer->setData(
    array
    (
        array('ID',  'Name',            'Kode'  ),
        array('1',   'Kab. Bogor',       '1'    ),
        array('2',   'Kab. Cianjur',     '1'    ),
        array('3',   'Kab. Sukabumi',    '1'    ),
        array('4',   'Kab. Tasikmalaya', '2'    )
    )
);                                                  // add some data to the writer
$excel->writer->saveFile('example');

?>