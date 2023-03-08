<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Produit;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {

        return $this->render('payment/index.html.twig',[
        ]);
    }

    #[Route('/success', name: 'app_success')]
    public function success(): Response
    {
        $email = (new Email())
                ->from('gymelite95@gmail.com')
                ->to ('youssef.hamrouni@esprit.tn')
                ->subject('Confirmation de paiement réussi')
                ->text('Cher(e) FOULEN,

Nous tenons à vous remercier pour votre achat chez ELITE GYM. Nous sommes heureux de vous informer que votre paiement a été traité avec succès et que votre commande a été confirmée.


Si vous avez des questions ou des préoccupations concernant votre commande, n"hésitez pas à nous contacter. Nous sommes à votre disposition pour vous aider dans tout ce dont vous avez besoin.

Nous vous remercions encore une fois pour votre confiance en notre entreprise.

Cordialement,
L"equipe ELITE GYM');
                $transport = new GmailSmtpTransport('gymelite95@gmail.com','sevlblnxqgzlxwnn');
                $mailer=new Mailer($transport);
                $mailer->send($email);

        return $this->render('payment/success.html.twig',[
        ]);


    }#[Route('/error', name: 'app_error')]
    public function error(): Response
    {

        return $this->render('payment/error.html.twig',[
        ]);
    }

    #[Route('/create-checkout-session', name: 'checkout')]
    public function checkout(SessionInterface $session): Response
    {
    
\Stripe\Stripe::setApiKey('sk_test_51MgySyD6nqQMhhhlBUGrK37DmEZjj2EtOSa7BgV6LDg05qEHXfaAFM0HFlUqqGsvmOZkfkwDuuLkNPAv1LLLErMo007RKbH3iq');
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://127.0.0.1:8000';
$panier = $session->get('panier', []);
    $items = [];
    $total = 0;
    foreach ($panier as $id => $quantite) {
      $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);
      if (!$produit) {
          throw $this->createNotFoundException('Produit non trouvé pour id '.$id);
      }
      $prix = $produit->getPrix();
      $total += $prix * $quantite;
      $items[] =[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $produit->getNom(),
            ],
            'unit_amount' => $prix * 100,
        ],
        'quantity' => $quantite,
    ];
}


$checkout_session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => $items,
  
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success',
  'cancel_url' => $YOUR_DOMAIN . '/error',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
       
    
    return $this->json(['id' => $checkout_session->id]);
    }
}