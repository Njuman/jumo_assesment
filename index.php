<?php 

include 'abstracts/reflectorAccessor.php';
include 'interfaces/iteratorInterface.php';
include 'iterators/renderIterator.php';
include 'iterators/groupIterator.php';
include 'iterators/sumIterator.php';
include 'iterators/countIterator.php';
include 'aggregate.php';

$file = fopen('Loans.csv', 'r');

$loans = array();
$header = null;

while ($row = fgetcsv($file)) {

    if ($header === null) {
        $header = $row;
        continue;
    }

    $row[2] = date("F", strtotime(str_replace("'", "", $row[2])));

    $loans[] = array_combine($header, $row);
}

$groupIterator = new groupIterator;
$renderIterator = new renderIterator;
$sumIterator = new sumIterator;
$countIterator = new countIterator;

$aggregate = new Aggregate($loans, $groupIterator, $sumIterator, $countIterator,$renderIterator);

$aggregate_loans = $aggregate->groupBy(array('Network','Product','Date'))
							 ->sum('Amount')
							 ->count()
							 ->render();

$filename = 'Output';

$fp = fopen($filename.'.csv', 'w');

$filepath = $_SERVER["DOCUMENT_ROOT"] .'\\'. $filename.'.csv';

foreach ($aggregate_loans as $fields) {
    fputcsv($fp, $fields);
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
header('Content-Length: ' . filesize($filepath)); 
echo readfile($filepath);