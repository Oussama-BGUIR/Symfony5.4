<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CalendarRepository;

class MainclientController extends AbstractController
{
    #[Route('/mainclient', name: 'app_mainclient')]
    public function index(CalendarRepository $calendar)
    {
        $events = $calendar->findAll();

        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->isAllDay(),
            ];
        }

        $data = json_encode($rdvs);

        return $this->render('mainclient/index.html.twig', compact('data'));
    }
}


// #[Route('/calclient', name: 'calendarclient', methods: ['GET'])]
// public function fullcalendar(RdvRepository $rdvRepository ,Request $request): Response
// {
//     $Rdvs = $rdvRepository->findAll();

//     $rdvs = [];
  
//     foreach ($Rdvs as $Rdv) {
//         // get date value from entity RDV
//         $date = $Rdv->getDate();
    
//         // set start date
//         $start = $date->format('Y-m-d H:i:s');
    
//         // set end date
//         $end = clone $date;
//         $end->add(new \DateInterval('PT2H'));
//         $end = $end->format('Y-m-d H:i:s');

     
//         $rdvs[] = [
//               'id' => $Rdv->getId(),
//             'title' => $Rdv->getNom(),
//             'start' => $start,
//             'end' => $end,
//             'color' => '#4FE9A4',
//             'textColor' => '#000000',
//             // 'editable'=>true,
//         ];
//     }

//     $data = json_encode($rdvs);

//     return $this->render('mainclient/index.html.twig', compact('data'));
// }