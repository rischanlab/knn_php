<?php

// deklarasi data dalam format array 
// ada 4 komponen yaitu nilai matematika, pengetahuan umum, bahasa inggris dan agama
// data diambil dari sumber terpercaya
$data = array(array(14,	12,	16,	13,	'FE1'),
array(16,	14,	13,	7,	'FE1'),
array(12,	13,	16,	16,	'FE1'),
array(14,	15,	21,	17,	'FE1'),
array(17,	14,	13,	10,	'FE1'),
array(15,	11,	10,	15,	'FE1'),
array(13,	9,	20,	11,	'FE1'),
array(18,	9,	14,	9,	'FE1'),
array(9,	16,	17,	13,	'FE1'),
array(13,	10,	14,	14,	'FE1'),
array(15,	8,	11,	6,	'FE3'),
array(16,	14,	15,	15,	'FE3'),
array(14,	14,	13,	11,	'FE3'),
array(21,	17,	17,	16,	'FH'),
array(14,	10,	17,	13,	'FH'),
array(13,	11,	20,	12,	'FH'),
array(9,	12,	14,	13,	'FH'),
array(12,	8,	15,	10,	'FH'),
array(7,	9,	15,	15,	'FH'),
array(16,	19,	14,	16,	'FH'),
array(16,	10,	17,	8,	'FH'),
array(15,	9,	18,	6,	'FH'),
array(15,	9,	18,	9,	'FH'),
array(10,	19,	12,	9,	'FH'),
array(14,	15,	17,	12,	'FIAI1'),
array(15,	8,	10,	10,	'FIAI1'),
array(18,	11,	18,	17,	'FMIPA3'),
array(16,	11,	18,	10,	'FMIPA3'),
array(8,	12,	12,	12,	'FMIPA3'),
array(16,	13,	15,	15,	'FMIPA3'),
array(9,	7,	9,	9,	'FMIPA3'),
array(13,	9,	13,	16,	'FMIPA3'),
array(9,	6,	11,	6,	'FMIPA3'),
array(18,	15,	18,	18,	'FPSB1'),
array(9,	19,	14,	17,	'FPSB1'),
array(13,	9,	15,	12,	'FTSP1'),
array(10,	7,	14,	15,	'FTSP1'),
array(19,	17,	12,	10,	'FTSP1'),
array(19,	13,	10,	12,	'FTSP1'),
array(17,	5,	17,	13,	'FTSP1'),
array(13,	7,	12,	12,	'FTSP3'),
array(17,	13,	12,	10,	'FTSP3'),
array(11,	10,	12,	11,	'FTSP3'),

);




// membuat jarak euclidance memanggil methode/function euclideanDistance
$distances = $data;
array_walk($distances, 'euclideanDistance', $data);
/** 
php manual
bool array_walk ( array &$array , callable $funcname [, mixed $userdata = NULL ] )
return true or false
array_walk — Apply a user function to every member of an array
*/
// Memanggil methode getNearsetNeighbors
$neighbors = getNearestNeighbors($distances, 15,	19,	15,	10);

echo getLabel($data, $neighbors) . "\n"; // Menampilakan Hasil ke layar


/**

 */
function euclideanDistance(&$sourceCoords, $sourceKey, $data)
{   
    $distances = array();
    list ($x1, $y1, $z1, $q1) = $sourceCoords;
    foreach ($data as $destinationKey => $destinationCoords) {
        
        if ($sourceKey == $destinationKey) {
            continue;
        }
        list ($x2, $y2, $z2, $q2) = $destinationCoords;
        $distances[$destinationKey] = sqrt(pow($x1 - $x2, 2) + pow($y1 - $y2, 2) + pow($z1 - $z2, 2) + pow($q1 - $q2, 2));
		// rumus untuk mencari jarak euclidean
		// setiap inputan akan dihitung jaraknya dengan nilai data yang ada dan di cari jarak terpendek(yang mendekatai dengan data yang tersedia)
		// akan dilakukan terus menerus looping sampai data statis semuanya telah di hitung jaraknya dengan inputan
    }
    asort($distances); 
	//asort(array,sorttype) asort fungsi untuk sorting array
    $sourceCoords = $distances;
}

/**
 * Returns n-nearest neighbors
 *
 */
function getNearestNeighbors($distances, $key, $num)
{
    return array_slice($distances[$key], 0, $num, true);
	//The array_slice() function returns selected parts of an array.
	/**
		*Example 

		*<?php
		*$a=array(0=>"Dog",1=>"Cat",2=>"Horse",3=>"Bird");
		*print_r(array_slice($a,1,2));
		*?>
		*The output of the code above will be:

		*Array ( [0] => Cat [1] => Horse )
	*/
	
}

/**
 * Gets result label from associated data
 *
 * @param array $data 
 * @param array $neighbors Result from getNearestNeighbors()
 * @return string label
 */
function getLabel($data, $neighbors)
{
    $results = array();
    $neighbors = array_keys($neighbors);
    foreach ($neighbors as $neighbor) {
        $results[] = $data[$neighbor][4];
    }
    $values = array_count_values($results);
    $values = array_flip($values);
		//The array_flip() function returns an array with all the original keys as values, and all original values as keys.
		/**
		*Example

		*<?php
		*$a=array(0=>"Dog",1=>"Cat",2=>"Horse");

		*print_r(array_flip($a));
		*?>
		*The output of the code above will be:

		*Array ( [Dog] => 0 [Cat] => 1 [Horse] => 2 )
		
		**/
	
    ksort($values);
	//The ksort() function sorts an array by the keys. The values keep their original keys.
	//This function returns TRUE on success, or FALSE on failure.
	
	
    return array_pop($values);
	//The array_pop() function deletes the last element of an array.
}
?>