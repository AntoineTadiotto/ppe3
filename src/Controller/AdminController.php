<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends BaseAdminController
{
 public function removeArticle($article){

    //si l'article a des commentaires
    if (!empty($article->getComments() ))
    {
    
    }

}

}