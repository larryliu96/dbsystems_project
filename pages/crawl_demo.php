<?php
session_start();
$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('dbsystems_test');
$product_name = $_POST['product_name'];
$id = $_SESSION['user_id'];
#$page = $_POST['page'];
$page = 1;
$appid = "knk9k3pjkdhhgrc842h9c7dx";
$searchquery = $product_name;
$api_endpoint = "http://api.walmartlabs.com/v1/search";
$urlParams = "apiKey=". $appid ."&query=" . $searchquery. "&start=". $page;

$fullUrl = $api_endpoint . '?' . $urlParams;
//print $fullUrl;
$connection = curl_init();
curl_setopt($connection, CURLOPT_URL, $fullUrl);
curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($connection, CURLOPT_HEADER, true);
curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($connection);
curl_close($connection);

$filepath = '/home/dbsystems/public_html/reponse.txt';
file_put_contents($filepath, $response);

$counter = 0;
$json_response = NULL;
if ($file = fopen($filepath, "r"))
{
    while(!feof($file))
    {
        $line = fgets($file);
        #check if this line has "{" if not then skip
        #if yes then read this line and set $counter = 1
        if (strpos($line, '{') !== false)
        {
            $counter = 1;
        }
        if ($counter == 1) //this is set to one means all lines needs to be read
        {
            $json_response .= $line;
        }
    }
    fclose($file);
}

$json_data = json_decode($json_response,true);
echo $json_response;
/*$output = "Product search for: ";
$output .= $searchquery;
$output .= "\r\n\r\n";*/
/*echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<style>";
echo "table {font-family: arial, sans-serif; table-layout: auto; border-collapse: collapse; width: 100%;}";
echo "table .absorbing-column {width: 100%;}";
echo "td, th {border: 1px solid #dddddd; text-align: left; padding: 8px;}";

echo "tr:nth-child(even) {  background-color: #dddddd;}";
echo "</style></head><body>";
echo "<p align='center'>";
echo "<table>";
echo "<thead>";
  echo "<tr>";
    echo "<th>Item Id</th>";
    echo "<th>Name</th>";
    echo "<th>MSRP</th>";
    echo "<th>Sales Price</th>";
    echo "<th>Customer Rating</th>";
    echo "<th>Buy</th>";

  echo "</tr>";
echo "</thead>";*/
/*
foreach ($json_data as $key1 => $value1)
{

    if ($key1 == "items")
    {
        foreach ($value1 as $key2 => $value2)
        {
            //echo "<tr>";
            //foreach ($value2 as $key3 => $value3)
            //{
		$itemId = $value1[$key2]["itemId"];
		$name = $value1[$key2]["name"];
		$URL = $value1[$key2]["productUrl"];
	    $img = $value1[$key2]["thumbnailImage"];
	    $description = $value1[$key2]["shortDescription"];
	    if($description )
		$customerRating = $value1[$key2]["customerRating"];
		$price = $value1[$key2]['salePrice'];
        $path = $value1[$key2]['categoryPath'];
        
        
		$sql = "INSERT INTO Product (item_id, item_name, item_url, item_rating, img_url, item_description, item_path) 
			VALUES ('$itemId', '$name', '$URL', '$customerRating', '$img', '$description', '$path')";
		$res = mysql_query($sql);
		if($res){
		    $sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$itemId', CURDATE() , '$price')";
		    $res2 = mysql_query($sql2); 
		}*/
/*
		
                if ($value1[$key2]["itemId"] != null)
                {
                    //echo "<td>";
                    $itemId = $value1[$key2]["itemId"];
		    echo $itemId;
                    //echo "</td>";
                }
                else
                {
               	    //echo "<td>";
                    //echo " ";
                    //echo "</td>";
                }

                if ($value1[$key2]["name"] != null)
                {
                    //echo "<td>";
                    $name = $value1[$key2]["name"];
		    echo $name;
                    //echo "</td>";
                }
                else
                {
               	    //echo "<td>";
                    //echo " ";
                    //echo "</td>";
                }
                
                if ($value1[$key2]["msrp"] != null)
                {
                    //echo "<td>";
                    //echo $value1[$key2]["msrp"];
                    //echo "</td>";
                }
                else
                {
               	    //echo "<td>";
                    //echo " ";
                    //echo "</td>";
                }
                
                if ($value1[$key2]["salePrice"] != null)
                {
                    //echo "<td>";
                    echo $value1[$key2]["salePrice"];
                    //echo "</td>";
                }
                else
                {
               	    //echo "<td>";
                    //echo " ";
                    //echo "</td>";
                }
                
                if ($value1[$key2]["customerRating"] != null)
                {
                    //echo "<td>";
                    echo $value1[$key2]["customerRating"];
                    //echo "</td>";
                }
                else
                {
               	    //echo "<td>";
                    //echo " ";
                    //echo "</td>";
                }
                
                if ($value1[$key2]["productUrl"] != null)
                {
                    //echo "<td>";
                    echo $value1[$key2]["productUrl"];
                    //echo "</td>";
                    //$value = $value1[$key2]["productUrl"];
                    //echo "<td align='center'><form action= $value><input type=\"submit\" value=\"Buy\"></form></td>";
                }
                else
                {
               	   //echo "<td align='center'><form action= \"http://walmart.com\"><input type=\"submit\" value=\"Buy\"></form></td>";
                }


            //}
            //echo "</tr>";
            //$output .= "\r\n";
        }
    }
}*/
//echo "</table>";
//echo "</p>";

//echo "</body>";
//echo "</html>";

#return $json_data;

mysql_close($link);
?>


