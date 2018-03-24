<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Facebook\Facebook;

class WetherController extends Controller
{
    /**
     * @Route("/wether", name="wether")
     */
    public function index()
    {
        $ch = \curl_init();

        // set url
        \curl_setopt($ch, CURLOPT_URL, "http://api.wunderground.com/api/SECRET/forecast/lang:UA/q/UA/Kiev.json");
        //return the transfer as a string
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string
        $output = \curl_exec($ch);
        // close curl resource to free up system resources
        \curl_close($ch);

        $city = json_decode($output)->forecast->simpleforecast->forecastday[0]->date->tz_long;


        $forecast = $city . ': ' . json_decode($output)->forecast->txt_forecast->forecastday[1]->title. ' - ' . json_decode($output)->forecast->txt_forecast->forecastday[1]->fcttext_metric;




        // $fb = new Facebook([
        //   'app_id' => '434511280338313',
        //   'app_secret' => 'SECRET',
        //   'default_graph_version' => 'v2.2',
        //   ]);

        // $linkData = [
        //     'message' => $forecast,
        //   ];

        //   $helper = $fb->getRedirectLoginHelper();

        // try {

        //     $accessToken = $helper->getAccessToken();
        //   // Returns a `Facebook\FacebookResponse` object
        //   $response = $fb->post('/me/feed', $linkData, $accessToken);
        // } catch(Facebook\Exceptions\FacebookResponseException $e) {
        //   echo 'Graph returned an error: ' . $e->getMessage();
        //   exit;
        // } catch(Facebook\Exceptions\FacebookSDKException $e) {
        //   echo 'Facebook SDK returned an error: ' . $e->getMessage();
        //   exit;
        // }

        // $graphNode = $response->getGraphNode();

        // echo 'Posted with id: ' . $graphNode['id'];
        

        return new Response($forecast);
    }
}
