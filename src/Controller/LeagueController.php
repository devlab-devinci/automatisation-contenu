<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LeagueController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function loggedAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $APIkey=$this->getParameter('API_KEY');
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

        return $this->render('default/logged.html.twig', [
            'matches' => $result
        ]);
    }

    /**
     * @Route("/history", name="history")
     */
    public function historyMatchesAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $APIkey=$this->getParameter('API_KEY');
        $from = date('Y-m-d', strtotime('-7 days'));
        $to = date('Y-m-d');

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

        return $this->render('league/history.html.twig', [
            'matches' => $result
        ]);
    }

    /**
     * @Route("/live", name="live")
     */
    public function liveMatchesAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $from = date('Y-m-d');
        $to = date('Y-m-d');
        $APIkey=$this->getParameter('API_KEY');

        // League ID 127 = Ligue 1 / Country ID 173 = France
        $curl_options = array(
            CURLOPT_URL => "https://apifootball.com/api/?action=get_events&from=$from&to=$to&country_id=173&league_id=127&match_live=1&APIkey=$APIkey",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 5
        );

        $curl = curl_init();
        curl_setopt_array( $curl, $curl_options );
        $result = curl_exec( $curl );

        $result = (array) json_decode($result);

        return $this->render('league/live.html.twig', [
            'matches' => $result
        ]);
    }
}
