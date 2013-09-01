<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Google Trend API - library
 *
 * This is a basic libary enable you to get google trends keywords as a JSON.
 * This library is used with the curl which I used a Curl library ( https://github.com/philsturgeon/codeigniter-curl ) .
 *
 * @package       CodeIgniter
 * @subpackage    Libraries
 * @author        kelvin Kwong Ho ( kelvinho84@gmail.com )
 * @version       0.1
 *
 */
class Gtrend
{
    protected $_ci;				 // CodeIgniter instance
    protected $response = '';	   // Contains the cURL response for debug
    protected $data_base_path = "/";

    function __construct($url = '')
	{
		$this->_ci = & get_instance();
		$this->_ci->load->library('curl');
		$this->data_base_path = $this->_ci->config->item('data_base_path');

	}
    /**
     * Call get_keywords checks local keywords already fetch to JSON file.
     * If yes, read and return array
     * Else, call create_trend_keyword to make
     *
     * @param category - id of the google cat
     * @param type - refere to the TOP or RISING query
     *
     * @return
     */
    function get_keyword ( $category = "0-18-78", $type ='TOP' ) {
        $result = array();
        $fileName = date('Ymd', time())."_{$type}_{$category}.json";
        $local_path = $this->data_base_path.$fileName;

        if ( file_exists($local_path) ) {
            $json = file_get_contents($local_path);
            $result = json_decode($json, TRUE);
            // 			debug($result, "File exists");
        } else {
            $result = $this->create_trend_keyword( $category, $type );
        }
        // 		debug($result, "key");
        return $result;
    }

    /**
     * category =
     * "0-18-78" => Shopping > Consumer Electronics
     * "0-5-78" => Computer & electronics > consumer Electronics
     */
    function create_trend_keyword( $category = "0-18-78", $type = "TOP", $local_path = NULL ){
        $result = array();
        if ( empty( $local_path )){
            $fileName = date('Ymd', time())."_{$type}_{$category}.json";
            $local_path = $this->data_base_path.$fileName;
        }
        $base_request_url = 'http://www.google.com/trends/fetchComponent?';
        $request = $base_request_url."hl=en-US&cat={$category}&geo=US&date=today+1-m&gprop=froogle&cmpt=q&content=1&cid={$type}_QUERIES_0_0&export=3";
        $response = $this->_ci->curl->simple_get($request);
        // $response = '// Data table response
        // google.visualization.Query.setResponse({"version":"0.6","status":"ok","sig":"1163449039","table":{"cols":[{"id":"query","label":"Query","type":"string","pattern":""},{"id":"amount","label":"Amount","type":"number","pattern":""},{"id":"internalUrl","label":"Product URL","type":"string","pattern":""},{"id":"externalUrl","label":"Search URL","type":"string","pattern":""}],"rows":[{"c":[{"v":"ipod"},{"v":100.0,"f":"100"},{"v":"#cat=0-18-78&geo=US&gprop=froogle&date=today+1-m&cmpt=q&q=%22ipod%22"},{"v":"http://www.google.com/products?q=%22ipod%22"}]},{"c":[{"v":"tv"},{"v":100.0,"f":"100"},{"v":"#cat=0-18-78&geo=US&gprop=froogle&date=today+1-m&cmpt=q&q=%22tv%22"},{"v":"http://www.google.com/products?q=%22tv%22"}]},{"c":[{"v":"camera"},{"v":90.0,"f":"90"},{"v":"#cat=0-18-78&geo=US&gprop=froogle&date=today+1-m&cmpt=q&q=%22camera%22"},{"v":"http://www.google.com/products?q=%22camera%22"}]},{"c":[{"v":"xbox"},{"v":90.0,"f":"90"},{"v":"#cat=0-18-78&geo=US&gprop=froogle&date=today+1-m&cmpt=q&q=%22xbox%22"},{"v":"http://www.google.com/products?q=%22xbox%22"}]},{"c":[{"v":"sony"},{"v":75.0,"f":"75"},{"v":"#cat=0-18-78&geo=US&gprop=froogle&date=today+1-m&cmpt=q&q=%22sony%22"},{"v":"http://www.google.com/products?q=%22sony%22"}]},{"c":[{"v":"speakers"},{"v":70.0,"f":"70"},{"v":"#cat=0-18-78&geo=US&gprop=froogle&date=today+1-m&cmpt=q&q=%22speakers%22"},{"v":"http://www.google.com/products?q=%22speakers%22"}]},{"c":[{"v":"nikon"},{"v":60.0,"f":"60"},{"v":"#cat=0-18-78&geo=US&gprop=froogle&date=today+1-m&cmpt=q&q=%22nikon%22"},{"v":"http://www.google.com/products?q=%22nikon%22"}]},{"c":[{"v":"samsung"},{"v":60.0,"f":"60"},{"v":"#cat=0-18-78&geo=US&gprop=froogle&date=today+1-m&cmpt=q&q=%22samsung%22"},{"v":"http://www.google.com/products?q=%22samsung%22"}]},{"c":[{"v":"xbox 360"},{"v":60.0,"f":"60"},{"v":"#cat=0-18-78&geo=US&gprop=froogle&date=today+1-m&cmpt=q&q=%22xbox+360%22"},{"v":"http://www.google.com/products?q=%22xbox+360%22"}]},{"c":[{"v":"headphones"},{"v":55.0,"f":"55"},{"v":"#cat=0-18-78&geo=US&gprop=froogle&date=today+1-m&cmpt=q&q=%22headphones%22"},{"v":"http://www.google.com/products?q=%22headphones%22"}]}]}});';
        if ( !empty( $response) ) {
            if ( strpos($response, 'You have reached your quota limit. Please try again later.') ) {
                echo("reached quota limit");
                return $result;
            }
            $response = substr( $response, 62, -2);
            $response_json = json_decode($response,TRUE);
            debug($response,$request);
            foreach ($response_json['table']['rows'] as $keyword){
                $result[] = $keyword['c'][0]['v'];
            }
            // 				debug($response, "File ! exists");
            if ( !empty( $result ) ){
                if ( !file_exists($local_path)) {
                    if(!file_exists(dirname($local_path))) {
                        mkdir(dirname($local_path), 0777, true);
                    }
                    file_put_contents($local_path, json_encode($result));
                }
            }
        }
        return $result;
    }
}
/* End of file Gtrend.php */
/* Location: ./application/libraries/Gtrend.php */