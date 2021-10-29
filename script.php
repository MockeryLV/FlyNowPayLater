<?php


require_once 'vendor/autoload.php';


use App\Models\InputData;
use App\Validators\InputDataValidator;

/*
 * console input should look like this: php script.php -i text.txt -f most-repeating -L -P -S
 */


function usingFlags(string $char, array $flags): string
{

    /*
     * this function does sort chars according to categories 'letter', 'punctuation' or 'symbol'
     */

    switch ($char) {
        case (ctype_alpha($char)):
            if (in_array('-L', $flags)) {
                return 'letter';
            }
            break;
        case (in_array($char, str_split("',;.?!`'"))):
            if (in_array('-P', $flags)) {
                return 'punctuation';
            }
            break;
        case (!in_array($char, str_split("',;.?!`'")) && !ctype_alpha($char)):
            if (in_array('-S', $flags)) {
                return 'symbol';
            }
            break;
        default:
            die('Something went wrong...');
    }

}


function setCharFrqArray(array $params){

    /*
     * this function sets up charFreq array using params ('-L' for letters, '-P' for punctuation and so on..)
     */

    $charToFrq = [];
    foreach ($params as $param) {
        switch ($param) {
            case '-L':
                $charToFrq['letter'] = [];
                break;
            case '-P':
                $charToFrq['punctuation'] = [];
                break;
            case '-S':
                $charToFrq['symbol'] = [];
                break;
            default:
                die('Something went wrong...');
        }
    }

    return $charToFrq;

}


function getCharFreqArray(array $chars, array $params): array
{

    /*
     * this function returns array charToFrq which shows relations between chars and their count (ex. 'letter' => [ 'a' => 12 ])
     * means: there is 12 letters 'a' in the string
     */

    sort($chars);

    $charToFrq = setCharFrqArray($params);

    $counter = 0;
    $currentChar = $chars[0];

    foreach ($chars as $item) {

        if ($item === $currentChar) {
            $counter++;
        } else {
            if (usingFlags($currentChar, $params)) {
                $charToFrq[usingFlags($currentChar, $params)][$currentChar] = $counter; // sorts letters, symbols and punctuations
                // in different arrays
            }
            $currentChar = $item;
            $counter = 1;
        }

    }

    if (usingFlags($currentChar, $params)) {
        $charToFrq[usingFlags($currentChar, $params)][$currentChar] = $counter;
    }

    return $charToFrq;
}

function getResponse(array $charToFrq, string $filter)
{

    switch ($filter) {
        case 'most-repeating':
            foreach ($charToFrq as $key => $item) {
                if (count($item) === 0 || max($item) === 1) {
                    echo "First most repeating $key: None" . PHP_EOL;
                } else {
                    echo "First most repeating $key: " . array_search(max($item), $item) . PHP_EOL;
                }
            }
            break;
        case 'least-repeating':
            foreach ($charToFrq as $key => $item) {

                if (count($item) === 0 || min($item) === 1) {
                    echo "First least repeating $key: None" . PHP_EOL;
                } else {
                    echo "First least repeating $key: " . array_search(min($item), $item) . PHP_EOL;
                }
            }
            break;
        case 'non-repeating':
            foreach ($charToFrq as $key => $item) {
                if (count($item) === 0 || min($item) !== 1) {
                    echo "First non-repeating $key: None" . PHP_EOL;
                } else {
                    echo "First non-repeating $key: " . array_search(min($item), $item) . PHP_EOL;
                }
            }
            break;
        default:
            die('Something went wrong...');
    }

}



$input = new InputData($argv);

$availableFilters = $input->getAvailableFilters();
$availableFilterFlags = $input->getAvailableFilterFlags();



$filter = $input->getFilter();
$params = $input->getParamFlags();
$file = $input->getTxtFile();
$content = str_split(file($input->getTxtFile())[0]);


echo "File: $file" . PHP_EOL; // Outputs 'File: txtFileName.txt'
getResponse(getCharFreqArray($content, $params), $filter); // Outputs "First 'chosen filter' letter/symbol/punctuation 'some value' "