GoogleTrend
===========

Google Trend API codeigniter php


This is a basic libary enable you to save google trends keywords as a JSON.
This library is used with the curl which I used a Curl library ( https://github.com/philsturgeon/codeigniter-curl ) .

package       CodeIgniter
subpackage    Libraries
author        kelvin Kwong Ho 
version       0.1
date          9/1/2013

Features
========
Get the google trend keywod and save as a JSON

Requirements
============
1. PHP 5.1+ with curl
2. CodeIgniter 

Example
=======
default call
------------
$response = $this->create_trend_keyword( );

$response :
["ipod","tv","camera","xbox","sony","speakers","nikon","xbox 360","headphones","ipod touch"]


Instruction
===========
1. Put the Gtrend.php under codeigniter "application/libraries" and make sure you have the Curl.php or $this->curl funtion
2. Loading the libraries by either one of the following way:  
a. Autoload 'config/Autoload.php' add a param in  $autoload['libraries'] = array('Curl', 'Gtrend');  
b. ```function __construct() {  
	parent::__construct();  
	$this->load->library('Gtrend');  
	}```  
c. ```$this->load->library('Gtrend');  ```
	
3. setup the JSON file data path :
$config['data_base_path'] = 'www/data/';
    
4. Call the library as follow :  
a. $result = $this->create_trend_keyword( ); //default is cat "0-18-78" => Shopping > Consumer Electronics, type TOP  
b. $result = $this->create_trend_keyword( $category, $type );

5. The keyword JSON is now stored as {data_base_path}/{Ymd_type_cat_}.json   
e.g. 20130901_TOP_0-18-78_.json  
Content : ["ipod","tv","camera","xbox","sony","speakers","nikon","xbox 360","headphones","ipod touch"]  



Download
========
https://github.com/kelvin2go/GoogleTrend/

Remarks:
The data is from  
http://www.google.com/trends/fetchComponent  
http://www.google.com/trends/fetchComponent?hl=en-US&cat=0-18-78&geo=US&date=today+1-m&gprop=froogle&cmpt=q&content=1&cid=TOP_QUERIES_0_0&export=3  


If you have any question

