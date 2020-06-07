<?php

namespace App\Controller;

use App\Entity\Departement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GestionController extends AbstractController
{
    /**
     * @Route("/etudiant", name="etudiant")
     */
    public function index()
    {
        return $this->render('gestion/index.html.twig', [
            'controller_name' => 'GestionController',
        ]);
    }
    /**
     * @Route("/etudiant/new",name="nouveau")
     * @Route("/etudiant/{id}/edit",name="etudiant_edit")
     */

    public function creer(Student $student=null,Request $request ){
        if(!$student){
            $student=new Student();
        }
        $manager = $this->getDoctrine()->getManager();
        $form=$this->createFormBuilder($student)
        ->add('FirstName',TextType::class)
        ->add('LastName', TextType::class)
        ->add('NumEtud')
        ->add('Departement',EntityType::class,[
            'class'=>Departement::class,
            'choice_label' =>'Name'
        ])
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($student);
            $manager->flush();
            return $this->redirectToRoute('acceuil');
        }
        return $this->render('gestion/creer_etudiant.html.twig',[
            'formEtud'=>$form->createView(),'id'=>$student->getId()
        ]);
    }
    /**
     * @Route("/", name="acceuil")
     */
    public function lister_tout(StudentRepository $repository){
        $etudiants=$repository->findAll();

        return $this->render('gestion/liste_etudiant.html.twig',[
            'etudiants'=>$etudiants
        ]);
    }

    /**
     * Undocumented function
     * @Route("supp/{id}", name="sup")
     *
     * @param Student $etudiants
     * @param ObjectManager $manager
     * @return Response
     */
    public function supprimer(Student $etudiants):Response
    {
        $id=$etudiants->getId();
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($etudiants);
        $manager->flush();
        return $this->json(['code'=>200,'id' =>$id],200);
    }
    
}
