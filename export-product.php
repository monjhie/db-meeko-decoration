<?php
include('db-connection.php');


$sql = "SELECT * FROM `tbl_items`";


$result = mysqli_query($conn, $sql);


if ( $result ) {


   $xml = new DOMDocument('1.0', 'UTF-8');
   $xml->formatOutput = true;


   $root = $xml->createElement('productList');
   $xml->appendChild($root);


   if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
           $entry = $xml->createElement('product');


           foreach ($row as $key => $value) {
               $node = $xml->createElement($key, htmlspecialchars($value));
               $entry->appendChild($node);
           }


           $root->appendChild($entry);
       }
   } else {
       echo 'No data found.';
       exit;
   }



   $xml->save('products_'.date('His-dmY').'.xml');


   header('Content-disposition: attachment; filename=products_'.date('d-m-Y_H-i').'.xml');
   header('Content-type: text/xml');
   echo $xml->saveXML();


} else {


   echo 'Error:'. $sql . "<br>" . mysqli_error($conn);


}




$conn->close();