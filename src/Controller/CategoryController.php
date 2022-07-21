<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/ajouter-une-category", name="create_category", methods={"GET|POST"})
     */
    public function creatCategory(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category)
            ->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $category->setAlias($slugger->slug($category->getName()));
                $category->setCreatedAt(new DateTime());
                $category->setUpdatedAt(new DateTime());

                $entityManager->persist($category);
                $entityManager->flush();

                $this->addFlash('Success', "La catégorie a bien été ajouté");
                return $this->redirectToRoute('show_dashboard');

            }

        return $this->render("admin/form/category.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/updated-une-category", name="update_category", methods={"GET|POST"})
     */
    public function updatedCategory(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {

        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category)
            ->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $category->setAlias($slugger->slug($category->getName()));
                $category->setUpdatedAt(new DateTime());

                $entityManager->persist($category);
                $entityManager->flush();

                $this->addFlash('Success', "La catégorie a bien été modifié");
                return $this->redirectToRoute('show_dashboard');

            }

            return $this->render("admin/form/category.html.twig", [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/archiver-un-category/{id}", name="soft_delete_category", methods={"GET"})
     */
    public function softDeleteCategory(Category $category, EntityManagerInterface $entityManager): RedirectResponse
    {
        $category->setDeletedAt(new DateTime());

        $entityManager->persist($category);
        $entityManager->flush();

        $this->addFlash('success', 'La catégorie a bien été archivé');
        return $this->redirectToRoute('show_dashboard'); 
    }
    /**
    * @Route("/restaurer-une-categorie/{id}", name="restore_category", methods={"GET"})
    */
    public function restoreCategory(Category $category, EntityManagerInterface $entityManager): RedirectResponse
    {
        $category->setDeletedAt(new DateTime());

        $entityManager->persist($category);
        $entityManager->flush();

        $this->addFlash('success', 'La catégorie a bien été restauré');
        return $this->redirectToRoute('show_dashboard'); 
    }

    /**
     * @Route("/supprimer-une-categorie/{id}", name="hard_delete_category", methods={"GET"})
     */
    public function hardDeleteCategory(Category $category, EntityManagerInterface $entityManager): RedirectResponse
    {
        $this->addFlash('success', 'La catégorie a bien été supprimé définitivement de la base');
        return $this->redirectToRoute('show_dashboard'); 
    }
}


