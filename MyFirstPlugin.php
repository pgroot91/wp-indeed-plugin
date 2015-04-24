<?php
/*
Plugin Name: My First Plugin
Plugin URI: http://yourdomain.com/
Description: A simple hello world wordpress plugin
Version: 1.0
Author: varun
Author URI: http://yourdomain.com
License: GPL
*/

add_action('admin_menu','myfirstplugin_admin_actions');
add_action( 'wp', 'prefix_setup_schedule' );

/**
 * On an early action hook, check if the hook is scheduled - if not, schedule it.
 */
function myfirstplugin_admin_actions()
{
add_options_page('Myfirstplugin', 'Myfirstplugin','manage_options',__File__,'myfirstplugin_admin');
}

function prefix_setup_schedule() {
	if ( ! wp_next_scheduled( 'prefix_hourly_event' ) ) {
		wp_schedule_event( time(), 'hourly', 'prefix_hourly_event');
	}
}
add_action( 'prefix_hourly_event', 'myfirstplugin_admin' );



function get_content($url,$ref="-",$p="",$c=""){
$cURL = curl_init();
curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($cURL, CURLOPT_HEADER, 0);
curl_setopt($cURL, CURLOPT_FAILONERROR, 0);
 curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);

 curl_setopt($cURL, CURLOPT_TIMEOUT, 300);
 curl_setopt($cURL, CURLOPT_CONNECTTIMEOUT, 300);

 curl_setopt($cURL, CURLOPT_URL, $url);
 //curl_setopt($cURL, CURLOPT_AUTOREFERER, 1);
 curl_setopt ($cURL, CURLOPT_SSL_VERIFYHOST, 0);
 curl_setopt ($cURL, CURLOPT_SSL_VERIFYPEER, 0);
 if ($p!=""){
 curl_setopt($cURL, CURLOPT_POSTFIELDS, $p);
 }
//curl_setopt($cURL, CURLOPT_COOKIE, "oxid-sid=074a8fb7cef0b1f4bbbdd0298152b641; oxid_2=info%40fjernstyret.dk%40%40%40oxoLB6aWo3WdU");
// if ($c==1){
//curl_setopt($cURL, CURLOPT_COOKIEJAR, "c:\yp.au.txt");
//curl_setopt($cURL, CURLOPT_COOKIEFILE,"c:\yp.au.txt");
//}

 curl_setopt($cURL, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:15.0) Gecko/20100101 Firefox/15.0.1");
 $strContent = curl_exec($cURL);
if ($strContent=="") $strContent=get_content($url,$ref,$p,$c);
 return $strContent;
 }





function myfirstplugin_admin(){

 //$xml="http://api.indeed.com/ads/apisearch?publisher=130629578390200&q=$q&l=&sort=&radius=&st=&jt=&start=$start&limit=3&//fromage=&filter=&latlong=0&co=us&chnl=&userip=1.2.3.4&useragent=Mozilla/%2F4.0%28Firefox%29&v=2";
$xml="http://api.indeed.com/ads/apisearch?publisher=130629578390200&q=h1b1&l=&sort=&radius=&st=&jt=&start=$start&limit=3&fromage=&filter=&latlong=0&co=us&chnl=&userip=1.2.3.4&useragent=Mozilla/%2F4.0%28Firefox%29&v=2";
echo "hanjiplugin h";
$f=get_content($xml);
//$f=get_content("cb.txt");
$fo=fopen("cb.txt","w");
fputs($fo,$f);
fclose($fo);
echo "<BR>";

$xml = simplexml_load_string($f);

if($f)
  {
   $parsed_xml = simplexml_load_string($f);
   $i=0;
   if($parsed_xml->results->result)
   foreach($parsed_xml->results->result as $current)
   {
     $jobkey    =  wp_filter_nohtml_kses($current->jobkey); 
     $jobtitle  =  wp_filter_nohtml_kses($current->jobtitle); 
     $company   =  wp_filter_nohtml_kses($current->company); 
     $city      =  wp_filter_nohtml_kses($current->city); 
     $state     =  wp_filter_nohtml_kses($current->state); 
     $country   =  wp_filter_nohtml_kses($current->country); 
     $description =  wp_filter_nohtml_kses($current->snippet); 
     $url       =  wp_filter_nohtml_kses($current->url); 
     $formatted_loc =  wp_filter_nohtml_kses($current->formattedLocation); 
     $formatted_loc_full =  wp_filter_nohtml_kses($current->formattedLocationFull); 

     $indeed_content[$i]=array(
                        'id'          => $jobkey,
                        'title'       => $jobtitle,
                        'company'     => $company,
                        'city'        => $city,
                        'state'       => $state,
                        'country'     => $country,
                        'description' => $description,
                        'formatted_loc'=> $formatted_loc,
                        'formatted_loc_full'=> $formatted_loc_full,
                        'url'          => $url,
                       );
     $i++;
 echo $jobtitle  ,$description ,$company;
	global $wpdb;

//$wpdb->insert('indeed',array('indeedID' => $jobkey,'title' => $jobtitle));
$wpdb->insert('indeed',array('indeedID' => $jobkey,'title' => $jobtitle,'description' => $desc,'company' => $company,'city'=>$city,'state'=>$state,'country'=>$country,'date'=>current_time('mysql', 1),'link'=>$url,'source'=>'ashokii')) ;// or die("error formed");

 echo $state;
    }
   }
  // print_r($indeed_content[0]);
}




















/*
$json = json_encode($xml);
$array = json_decode($json,TRUE);
//print_r($array);
//var_dump($array);
//die();





echo count(array([result])) ;
echo array([result]);

echo count(array([state])) ;

echo count(array([jobtitle])) ;

echo count(array([date])) ;







$results=$array["TotalPages"];
//echo $results;

if (isset($array["TotalPages"]))$totalpages=$array["TotalPages"]; else $totalpages=1;
$totalcount=$array["TotalCount"];

$results=$array["Results"]["JobSearchResult"];
//var_dump($results);
//die();
if ($totalcount==1){
$results1=array();
$results1[]=$results;
$results=$results1;}

$results = is_array($results) ? $results : array();

foreach($results as $rez){
//var_dump($rez);
$jobtitle=$rez["JobTitle"];
$company=$rez["Company"];
$city=$rez["Location"];
//$state=$rez['state'][0];
//$country=$rez['country'][0];
//$date=$rez['date'][0];
$snippet=$rez["DescriptionTeaser"];
$jobkey=$rez["DID"];
$url='ashokashok';
$expired='0';

$desc="";

$wpdb->insert('indeed',array('indeedID' => $jobkey,'title' => $jobtitle,'description' => $desc,'company' => $company,'city'=>$city,'state'=>'','country'=>'','date'=>current_time('mysql', 1),'snippet'=>$snippet,'expired'=>$expired,'link'=>$url, 'jobID'=>$job->jobID, 'source'=>'cb'));
}
}
*/	?>

