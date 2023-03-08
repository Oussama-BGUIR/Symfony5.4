<?php

namespace App\Controller;

use DateInterval;
use App\Entity\Rdv;
use App\Form\RdvType;
use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\RdvRepository;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use App\Repository\CalendarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;


#[Route('/rdv')]
class RdvController extends AbstractController
{
    #[Route('/', name: 'app_rdv_index', methods: ['GET'])]
    public function index(RdvRepository $rdvRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $Rdv = $rdvRepository->findAll();
        $Rdv   = $paginator->paginate(
            $Rdv  , /* query NOT result */
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('rdv/index.html.twig', [
           'Rdv'=>$Rdv
        ]);
    }

    #[Route('/calclient', name: 'calendarclient', methods: ['GET'])]
    public function fullcalendar(RdvRepository $rdvRepository ,Request $request): Response
    {
        $Rdvs = $rdvRepository->findAll();

        $rdvs = [];
      
        foreach ($Rdvs as $Rdv) {
            // get date value from entity RDV
            $date = $Rdv->getDate();
        
            // set start date
            $start = $date->format('Y-m-d H:i:s');
        
            // set end date
            $end = clone $date;
            $end->add(new \DateInterval('PT2H'));
            $end = $end->format('Y-m-d H:i:s');
    
         
            $rdvs[] = [
                  'id' => $Rdv->getId(),
                'title' => $Rdv->getNom(),
                'start' => $start,
                'end' => $end,
                'color' => '#4FE9A4',
                'textColor' => '#000000',
                // 'editable'=>true,
            ];
        }

        $data = json_encode($rdvs);

        return $this->render('mainclient/index.html.twig', compact('data'));
    }

 

    #[Route('/new', name: 'app_rdv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RdvRepository $rdvRepository ): Response
    {
        $rdv = new Rdv();
        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);

     
    if ($form->isSubmitted() && $form->isValid()) 
    {
        // $date_rdv = $rdv->getDate(); // Obtenez la date du RDV de votre entité RDV

        // $timestamp = strtotime($date_rdv->format('Y-m-d'));
        // $timestamp_jour_avant = $timestamp - 86400;
        // $date_rappel = new \DateTime(date('Y-m-d', $timestamp_jour_avant)); // Créez un nouvel objet DateTime à partir de la date de rappel
        
        // // Envoi du mail de rappel si la date de rappel est égale à la date système (j-1)
        // if ($date_rappel->format('Y-m-d') === (new \DateTime('now'))->modify('-1 day')->format('Y-m-d')) {
        //     // Envoyer l'e-mail de rappel
        //     $emailDestinataire = $rdv->getEmail();
        //     $email = (new Email())
        //         ->from('gymelite95@gmail.com')
        //         ->to($emailDestinataire)
        //         ->subject('ELITE GYM')
        //         ->text(sprintf('Votre rendez-vous avec le nutritionniste %s est prévu pour le %s. Nous vous rappelons que votre rendez-vous est dans 1 jour.', $rdv->getNomNutritioniste(), $date_rdv->format('d/m/Y')));
                
        //     $transport = new GmailSmtpTransport('gymelite95@gmail.com','sevlblnxqgzlxwnn');
        //     $mailer=new Mailer($transport);
        //     $mailer->send($email);
        // }
        
        

        $emailDestinataire = $rdv->getEmail();
        $email = (new Email())
                ->from('gymelite95@gmail.com')
                ->to($emailDestinataire)
                ->subject('ELITE GYM')
                ->text(sprintf('Votre rendez-vous avec le nutritionniste %s a été enregistré avec succès', $rdv->getNomNutritioniste()));

                $transport = new GmailSmtpTransport('gymelite95@gmail.com','sevlblnxqgzlxwnn');
                $mailer=new Mailer($transport);
                $mailer->send($email);
         $date = $rdv->getDate();
         $nomNutritioniste = $rdv->getNomNutritioniste();

        // Vérifier si la date est déjà prise
        $existingRdv = $this->getDoctrine()
            ->getRepository(Rdv::class)
            ->findOneBy(['date' => $date, 'nom_nutritioniste' => $nomNutritioniste]);

        if ($existingRdv) {
            $this->addFlash('error', 'Cet date est déja prise');
                        return $this->redirectToRoute('app_rdv_new');
        }

        else {
            $this->addFlash('success', 'Rendez-vous enregistré');
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($rdv);
        $entityManager->flush();
        
            return $this->redirectToRoute('app_rdv_new');
        }

        return $this->renderForm('rdv/new.html.twig', [
            'rdv' => $rdv,
            'form' => $form,
        ]);
    }

    
    #[Route('/{id}', name: 'app_rdv_show', methods: ['GET'])]
    public function show(Rdv $rdv): Response
    {
        return $this->render('rdv/show.html.twig', [
            'rdv' => $rdv,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rdv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rdv $rdv, RdvRepository $rdvRepository): Response
    {
        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'rendez-vous modifié');
            $rdvRepository->add($rdv, true);

            return $this->redirectToRoute('app_rdv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rdv/edit.html.twig', [
            'rdv' => $rdv,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rdv_delete', methods: ['POST'])]
    public function delete(Request $request, Rdv $rdv, RdvRepository $rdvRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rdv->getId(), $request->request->get('_token'))) {
            $rdvRepository->remove($rdv, true);
            $this->addFlash('success', 'Rendez-vous supprimé');
        }

        return $this->redirectToRoute('app_rdv_index', [], Response::HTTP_SEE_OTHER);
    }
}
