<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\Visual;

class LeagueController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function loggedAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $APIkey=$this->getParameter('FOOTBALL_API_KEY');
        $from = date('Y-m-d');
        $to = date('Y-m-d', strtotime('+5 days'));

        // League ID 127 = Ligue 1 / Country ID 173 = France
        $curl_options = array(
            CURLOPT_URL => "https://apifootball.com/api/?action=get_events&from=$from&to=$to&country_id=173&league_id=127&APIkey=4775edf0762587eae1b3350c7fdeac88361107dcf511eb2b6b83f3f1b8f4824e",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 5
        );

        $curl = curl_init();
        curl_setopt_array( $curl, $curl_options );
        $result = curl_exec( $curl );
        $result = (array) json_decode($result);

        // Json file if apiKey don't work
        $matchesJson = file_get_contents(__DIR__ . '/../../public/data/matches.json');



        return $this->render('default/logged.html.twig', [
            'matches' => $result,
        ]);
    }

    /**
     * @Route("/history", name="history")
     */
    public function historyMatchesAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $APIkey=$this->getParameter('FOOTBALL_API_KEY');
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
    public function liveMatchesAction(Request $request = null)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $from = date('Y-m-d');
        $to = date('Y-m-d');
        $APIkey=$this->getParameter('FOOTBALL_API_KEY');

        // League ID 127 = Ligue 1 / Country ID 173 = France
        $curl_options = array(
            CURLOPT_URL => "https://apifootball.com/api/?action=get_events&from=$from&to=$to&country_id=173&league_id=127&match_live=1&APIkey=$APIkey",
            //CURLOPT_URL => 'https://apifootball.com/api/?action=get_events&from=2018-12-01&to=2018-12-30&country_id=169&league_id=63&APIkey='.$APIkey,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 5
        );

        $curl = curl_init();
        curl_setopt_array( $curl, $curl_options );
        $result = curl_exec( $curl );

        $result = (array) json_decode($result);

        if ($request->request->get('ajaxEnabled')) {
            return new JsonResponse($result);
        }

        return $this->render('league/live.html.twig', [
            'matches' => $result
        ]);
    }

    /**
     * @param Request $request
     * @param UserInterface $user
     * @Route("/publishVisual", name="publishVisual")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function publishVisual(Request $request, UserInterface $user)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repositoryVisual = $this->getDoctrine()->getRepository(Visual::class);
        $visuals = $repositoryVisual->findBy(['userId' => $user->getId()], ['createdAt' => 'DESC']);

        return $this->render('league/publishCondition.html.twig', [
            'visuals' => $visuals,
        ]);

    }

    /**
     * @param Request $request
     * @param UserInterface $user
     * @Route("/publishVisual/{id_visual}", name="conditions")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function conditions(Request $request, UserInterface $user, $id_visual)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('league/conditions.html.twig', [

        ]);

    }
}
