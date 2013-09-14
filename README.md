GoogleTrend
===========

Google Trend API codeigniter php


This is a basic libary enable you to read/save google trends keywords as a JSON once a day. If JSON appear, read it. If not, curl the keyword and save as a JSON for next request. 
This library is used with the curl.

package       CodeIgniter / PHP
subpackage    Libraries
author        kelvin Kwong Ho 
version       0.1
date          9/1/2013

Requirements
============
1. PHP 5.1+ with curl which I used a Curl library ( https://github.com/philsturgeon/codeigniter-curl ) .
2. CodeIgniter 

What to solve
=============
For some moments, my site needs a content or keyword for dynamic run or request. Like the site of http://zonmine.com, call google trend once a day to gather the hot keyword in shopping (for 30 days and 7 days ).
Then it uses the Gtrend keyword to search products in Amazon. The content will appear updating daily and easily go up to 2000-5000 products in few days.

Features
========
Get the google trend keywod and save as a JSON
Example
=======
default call
------------
<pre>
$response = $this->create_trend_keyword( );

//return json ["ipod","tv","camera","xbox","sony","speakers","nikon","xbox 360","headphones","ipod touch"]
</pre>

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


Example of usage on website
===========================
http://zonmine.com

Remarks:
--------
The data is from  
http://www.google.com/trends/fetchComponent  
  
http://www.google.com/trends/fetchComponent?hl=en-US&cat=0-18-78&geo=US&date=today+1-m&gprop=froogle&cmpt=q&content=1&cid=TOP_QUERIES_0_0&export=3  

You will have chance reach your limit for curling google trends.

If you have any questions or found any bugs, please message or pull request me. 

