<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Commande;
use App\Entity\InfoUser;
use Symfony\Flex\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PdfController extends Controller
{
    /**
     * @Route("/pdf/{id}", name="pdf")
     */
    public function index(Commande $commande, \Swift_Mailer $mailer)
    {
        
        
        
        $lacommande = $this->getDoctrine()->getRepository(Commande::class)->findOneBy([
            "id" => $commande,             
            ]);

        $lignes = $commande->getLigneCommandes();
            
            // $mailer->send($message);
            //$mailer->send($message);
            // return $this->render('\pdf\facture.html.twig', [
            //     'commande' => $commande,
            //     'lignes' => $lignes
            //     ]);
        
        
         $pdfOptions = new Options();
         $pdfOptions->set('defaultFont', 'Arial');
    
         
        // // Instantiate Dompdf with our options
         $dompdf = new Dompdf($pdfOptions);
    
        // // Retrieve the HTML generated in our twig file
         $html = $this->renderView('pdf/facture.html.twig', [
             'title' => "Welcome to our PDF Test",
             'commande' => $commande,
             'lignes' => $lignes
             ]);
        
        //     // Load HTML to Dompdf
             $dompdf->loadHtml($html);
        
        //     // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
             $dompdf->setPaper('A4', 'portrait');
        
        //     // Render the HTML as PDF
             $dompdf->render();
             //génère le pdf directement dans le navigateur
             // Output the generated PDF to Browser (inline view)
            
             //ceci règle le problème pour stream le pdf sur un serveur
             ob_end_clean();
             $dompdf->stream("facture.pdf", [
                          "Attachment" => false
                      ]);
            
            
            //         //Génère le pdf et le sauvegarde dans un dossier mais erreur a fix
            //         // Store PDF Binary Data
            //         $output = $dompdf->output();
            
            
            //         // In this case, we want to write the file in the public directory
            //         $publicDirectory = $this->get('kernel')->getProjectDir() . '/public/pdf';
            //         // e.g /var/www/project/public/mypdf.pdf
            //         $pdfFilepath =  $publicDirectory . '/facture.pdf';
            
            //         // Write file to the desired path
            //         file_put_contents($pdfFilepath, $output);
            
            //         // Send some text response
            //         //return new Response("The PDF file has been succesfully generated !");
            
            
            
            //         $message = (new \Swift_Message())
            //         ->setFrom('antoine.tadiotto@gmail.com')
            //         ->setTo('antoine.tadiotto@gmail.com')
            //         ->setSubject('Information de votre commande');
            //         //->setBody('Body')
            //         $attachement = \Swift_Attachment::fromPath($pdfFilepath);
            
            //         $message->attach($attachement);
                // Configure Dompdf according to your needs
            
                }
            }
            