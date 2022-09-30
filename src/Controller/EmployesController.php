<?php

namespace App\Controller;

use App\Entity\Employes;
use App\Form\EmployesType;
use App\Repository\EmployesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployesController extends AbstractController
{
    #[Route('/', name: 'app_employes')]
    public function index(): Response
    {
       
        return $this->render('employes/index.html.twig', [
            
        ]);
    }
    #[Route('/liste', name: 'Liste')]
    public function liste(EmployesRepository $repo): Response
    {
        $employes = $repo->findAll();
        return $this->render('employes/liste.html.twig', [
            'all' => $employes
        ]);
    }
    #[Route("/employes/show/{id}", name:"employes_show")]
    public function show($id, EmployesRepository $repo){
        $employes = $repo->find($id);
        return $this->render('employes/show.html.twig', [
            'employes' => $employes
        ]);
    }
    #[Route("/employes/new", name:"employes_create")]
    #[Route("/employes/edit/{id}", name:"employes_edit")]
    public function form(Request $globals, EntityManagerInterface $manager, Employes $employes= null)
    {
        
        if($employes ==null):
            $employes = new Employes;
        endif;


        $form= $this->createForm(EmployesType::class, $employes );

        $form->handleRequest($globals);


        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($employes);
            $manager->flush();
            return $this->redirectToRoute('blog_show', [
                'id' => $employes->getId()
            ]);
        }

        return $this->renderForm("employes/form.html.twig", [
            "formEmployes" => $form,
            "editMode" => $employes->getId() !== null
        ]);

    }
    #[Route("/employes/delete/{id}", name:"employes_delete")]
    public function delete($id, EntityManagerInterface $manager, EmployesRepository $repo)
    {
        $employes= $repo->find($id);

        $manager->remove($employes);
        $manager->flush();
        return $this->redirectToRoute('app_employes');
    }
}
