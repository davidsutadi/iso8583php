<?php
include './src/iso8583.php';

/* Example extract iso string to bit data */

$iso = 'ISO0160000100200F238860128A09018000000001600000416603298900001426931100000000000000000000002280751280043761451281702281702280210  1111111111111376032989000014269=22011261357460800000678250574920S1ANCR29        CLEAR 2 PAY           JAKARTA      DKIID360F24AF7E47EA1CA5C012M00BTES1+000013MDR2TES11100P01316816003200000000100000';
$arr = iso2arr($iso,12);
print_r($arr);

/* output :
[bit] => Array(    [val] => Array(
  [0] => 1           [0] => 0000000016000004
  [1] => 2           [1] => 6032989000014269
  [2] => 3           [2] => 311000
  [3] => 4           [3] => 000000000000000000
  [4] => 7           [4] => 0228075128
  [5] => 11          [5] => 004376
  [6] => 12          [6] => 145128
  [7] => 13          [7] => 170228
  [8] => 17          [8] => 170228
  [9] => 22          [9] => 021
  [10] => 23         [10] => 0
  [11] => 32         [11] => 11111111111
  [12] => 35         [12] => 6032989000014269=22011261357460800000
  [13] => 37         [13] => 678250574920
  [14] => 41         [14] => S1ANCR29
  [15] => 43         [15] => CLEAR 2 PAY           JAKARTA      DKIID
  [16] => 49         [16] => 360
  [17] => 52         [17] => F24AF7E47EA1CA5C
  [18] => 60         [18] => M00BTES1+000
  [19] => 61         [19] => MDR2TES11100P
  [20] => 100        [20] => 3
  [21] => 102        [21] => 8160032000000001
  [22] => 103        [22] =>
  [23] => 126        [23] =>
)                  )
*/

/* Example create iso string from bit data */ 

$arr = array(
'pfx' => 'ISO016000010',
'mti' => '0200',
  2   => '6032989000014269',
  3   => '311000',
  4   => '000000000000000000',
  7   => '0228075128',
  11  => '004376',
  12  => '145128',
  13  => '170228',
  17  => '170228',
  22  => '021',
  23  => '0',
  32  => '11111111111',
  35  => '6032989000014269=22011261357460800000',
  37  => '678250574920',
  41  => 'S1ANCR29',
  43  => 'CLEAR 2 PAY           JAKARTA      DKIID',
  49  => '360',
  52  => 'F24AF7E47EA1CA5C',
  60  => 'M00BTES1+000',
  61  => 'MDR2TES11100P',
  100 => '3',
  102 => '8160032000000001',
  103 => '',
  126 => ''
);
echo iso2str($arr);
/* output :
ISO0160000100200F238860128A09018000000001600000416603298900001426931100000000000000000000002280751280043761451281702281702280210  1111111111111376032989000014269=22011261357460800000678250574920S1ANCR29        CLEAR 2 PAY           JAKARTA      DKIID360F24AF7E47EA1CA5C012M00BTES1+000013MDR2TES11100P01316816003200000000100000
*/
?>