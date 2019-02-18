<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction()
    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $APIkey=$this->getParameter('FOOTBALL_API_KEY');
        $from = date('Y-m-d');
        $to = date('Y-m-d', strtotime('+3 days'));

        // League ID 127 = Ligue 1 / Country ID 173 = France
        $curl_options = array(
            CURLOPT_URL => "https://apifootball.com/api/?action=get_events&from=$from&to=$to&country_id=173&league_id=127&APIkey=$APIkey",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 5
        );

        $curl = curl_init();
        curl_setopt_array( $curl, $curl_options );
        $result = curl_exec( $curl );

        $result = (array) json_decode($result);

        // RSS

        $rss = simplexml_load_file('https://rmcsport.bfmtv.com/rss/football/');

        return $this->render('default/index.html.twig', [
            'matches' => $result,
            'rss' => $rss
        ]);
    }
}
