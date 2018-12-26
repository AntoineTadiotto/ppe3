<?php

namespace App\Controller;

use DateTime;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commande;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\PieChart\PieSlice;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use App\Entity\LigneCommande;


class AdminController extends BaseAdminController
{



    public function removeArticle($article)
    {

    //si l'article a des commentaires
        if (!empty($article->getComments())) {

        }

    }
    /**
     * @Route("/admin/stats", name="stats")
     */
    public function voirStats()
    {

        $repoCommande = $this->getDoctrine()->getRepository(Commande::class);
        // $commandes = $repoCommande->findBy();

        $em = $this->getDoctrine()->getManager();

        $date = new DateTime();

        $conn = $em->getConnection();
        
        
        $sql = "
        SELECT EXTRACT(YEAR_MONTH FROM created_at) as date, COUNT(1) AS nbr
        FROM commande 
        WHERE created_at >= DATE_FORMAT(CURDATE(),'%2014-%m') 
        GROUP BY EXTRACT(YEAR_MONTH FROM created_at)
        ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        // $sql = "
        // SELECT DATE(created_at) as date, COUNT(1) AS nbr
        // FROM commande 
        // WHERE created_at >= DATE_FORMAT(CURDATE(),'%2014-%m') 
        // GROUP BY DATE(created_at)
        //  "; 
    // // returns an array of arrays (i.e. a raw data set)
        $commandes = $stmt->fetchAll();
        $data = array(['date', 'nbr']);

        foreach ($commandes as $row) {
            $date = $row['date'];
            // $value = date('Y-m', strtotime($date));
            $value = DateTime::createFromFormat('Ym', $date);
            $ladate = $value->format('Y-m');

            $nbr = $row['nbr'];
            $qte = intval($nbr);

            $data[] = ([$ladate, $qte]);
        }



        $chart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\LineChart();
        $chart->getData()->setArrayToDataTable($data);

        $chart->getOptions()->getChart()
            ->setTitle('Nombres de commandes par mois depuis 2014');
        $chart->getOptions()
            ->setHeight(400)
            ->setWidth(900)
            ->setSeries([['axis' => 'Temps'], ['axis' => 'Daylight']])
            ->setAxes(['y' => ['Temps' => ['label' => 'Nombres de commandes'], 'Daylight' => ['label' => 'Daylight']]]);

        // $repoLignes = $this->getDoctrine()->getRepository(LigneCommande::class);
        // $lignes = $repoLignes->findAll();
        
        // requête qui récupère tout les lignecommande et qui les group par article ID et qui SUM par quantité


        // $sql = "
        // SELECT article_id as article, sum(quantity) AS  
        // FROM commande 
        // WHERE created_at >= DATE_FORMAT(CURDATE(),'%2014-%m') 
        // GROUP BY EXTRACT(YEAR_MONTH FROM created_at)
        // ";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // $lignes = $stmt->fetchAll();
        // foreach ($categories as $category) {
        //     $title = $category->getTitle();
        //     $arraycat[] = [$title];
        // }
        // dump($arraycat);

        // foreach ($articles as $article) {

        // }


        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [
                ['Pac Man', 'Percentage'],
                ['Souris', 75],
                ['Clavier', 25]
            ]
        );
        $pieChart->getOptions()->getLegend()->setPosition('1');
        $pieChart->getOptions()->setPieSliceText('oui');
        $pieChart->getOptions()->setPieStartAngle(135);

        $pieSlice1 = new PieSlice();
        $pieSlice1->setColor('yellow');
        $pieSlice2 = new PieSlice();
        $pieSlice2->setColor('green');
        $pieChart->getOptions()->setSlices([$pieSlice1, $pieSlice2]);

        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTooltip()->setTrigger('oui');

        return $this->render('admin/stat.html.twig', [
            'chart' => $chart,
            'pieChart' => $pieChart
        ]);
    }


}