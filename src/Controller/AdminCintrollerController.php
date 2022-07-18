<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminCintrollerController extends AbstractController
{
    /**
     * @Route("/tableau-de-bord", name="show_dashboard", methods={"GET"})
     */
    public function showDashboard(EntityManagerInterface $entityManager): Response
    {
       return $this->render("admin/show_dashboard.html.twig");
    }
    public function createArticle(Request $reuest, EntityManagerInterface $ entityManager, SluggerInterface $slugger): Response
    {
        
    }
}
