<?php
ob_start();
require_once('TwitterAPIExchange.php');

/*curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, True); 
curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 2); 
curl_setopt($connection, CURLOPT_CAINFO, "H:\wamp\www\Twitter API\ca-bundle.crt");*/


/*define('TWEET_LIMIT', 5);
define('TWITTER_USERNAME', '');
define('CONSUMER_KEY', '');
define('CONSUMER_SECRET', '');
define('ACCESS_TOKEN', '');
define('ACCESS_TOKEN_SECRET', '');*/

$settings = array(
    'oauth_access_token' => "",
    'oauth_access_token_secret' => "",
    'consumer_key' => "",
    'consumer_secret' => "",
);

//$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

//url for getting list of followers
//$url = 'https://api.twitter.com/1.1/follower  s/list.json';
//$getfield = '?username=abhinay_balusu&skip_status=1';

//url for getting all the tweets related to a particular hashtag
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=%23usopen&result_type=recent&count=100';

//url to pass location details to twitter api
//$url = 'https://api.twitter.com/1.1/geo/reverse_geocode.json';
//$getfield = '?lat=37.76893497&long=-122.42284884';

//url to pass location details along with the tweet to twitter api
//$url = 'https://api.twitter.com/1.1/statuses/update.json';
//$getfield = '?status=test&lat=35.2269&long=80.8433';

$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
			 
$string = json_decode($twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest(),$assoc = TRUE);

echo "<pre>";
//print_r($string['statuses']);
$data = Array();
array_push($data, Array('ID', 'ID_STR', 'Text', 'User_Name', 'Description', 'Retweet_Count', 'Favorite_Count'));
foreach ($string['statuses'] as $item){
    //print_r($item);
    array_push($data, Array($item['id'], $item['id_str'], $item['text'], $item['user']['name'], $item['user']['description'], $item['retweet_count'], $item['favorite_count']));
    /*echo 'ID:';
    print_r($item['id']);
    echo '<br>ID STR:';
    print_r($item['id_str']);
    echo '<br>Text:';
    print_r($item['text']);
    echo '<br>User Name:' ;
    print_r($item['user']['name']);
    echo '<br>Description:';
    print_r($item['user']['description']);
    echo '<br>Retweetcount:';
    print_r($item['retweet_count']);
    echo '<br>Favorite Count:';
    print_r($item['favorite_count']);
    echo '<br>';*/
}
print_r($data);

echo "</pre>";

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');


require_once dirname(__FILE__) . '/PHPExcel/PHPExcel.php';

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Pavan Kumar")
    ->setLastModifiedBy("Pavan Kumar")
    ->setTitle("PHPExcel Test Document")
    ->setSubject("PHPExcel Test Document")
    ->setDescription("Test document for PHPExcel, generated using PHP classes.")
    ->setKeywords("office PHPExcel php")
    ->setCategory("Test result file");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'ID')
    ->setCellValue('B1', 'ID_STR')
    ->setCellValue('C1', 'Text')
    ->setCellValue('D1', 'User_Name')
    ->setCellValue('E1', 'Description')
    ->setCellValue('F1', 'Retweet_Count')
    ->setCellValue('G1', 'Favorite_Count');

$sheet = array(
    array(
        'a1 data',
        'b1 data',
        'c1 data',
        'd1 data',
    )
);
$objPHPExcel->getActiveSheet()->fromArray($data, null, 'A1');

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    echo 'Worksheet - ' , $worksheet->getTitle() , EOL;

    foreach ($worksheet->getRowIterator() as $row) {
        echo '    Row number - ' , $row->getRowIndex() , EOL;

        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
        foreach ($cellIterator as $cell) {
            if (!is_null($cell)) {
                echo '        Cell - ' , $cell->getCoordinate() , ' - ' , $cell->getCalculatedValue() , EOL;
            }
        }
    }
}

$objPHPExcel->getActiveSheet()->setTitle('Simple');

$objPHPExcel->setActiveSheetIndex(0);
$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace('.php', '.xls', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
?>