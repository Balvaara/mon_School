<?php

namespace App\Controller;

use App\Entity\Cycle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
    * @Route("/api")
    */
class CycleController extends AbstractController
{
    /**
    * @Route("/ajouter_cycle", methods={"POST"})
    */

   public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
   {

       
       $users = $this->getUser();

       $cycle=$serializer->deserialize($request->getContent(), Cycle::class, 'json');

       // $this-> denyAccessUnlessGranted(['ROLE_SUP_ADMIN','ROLE_ADMIN','ROLE_PARTENAIRE']);

       $errors = $validator->validate($cycle);
       if(count($errors)) {
           $errors = $serializer->serialize($errors, 'json');
           return new Response($errors, 500, [
               'Content-Type' => 'application/json'
           ]);
           }
        $data =json_decode($request->getContent());

          $cycle->setLibelle(strtoupper($data->libelle));
           $entityManager->persist($cycle);
           $entityManager->flush();

           $data = [
               'status' => 201,
               'message' => $cycle->getlibelle().' cree avec succes'
           ];
           return new JsonResponse($data, 200);
     

   }


             /**
             * @Route("/getCy/{id}",  methods={"GET"})
             */
            public function getById($id, EntityManagerInterface $entityManager)
            {
                $classeUpdate = $entityManager->getRepository(Cycle::class)->find($id);
                
                
                
                return $this->json($classeUpdate, 200);
          
            }

            /**
             * @Route("/delete_cy/{id}", methods={"DELETE"})
             */

            public function delete($id)
            {
                $users = $this->getUser();

                $rep = $this->getDoctrine()->getRepository(Cycle::class);
                // $status='';
                $mat=$rep->find($id);
                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->remove($mat);
                $entityManager->flush();
                $data = [
                    'status' => 201,
                    'message' => 'Cycle supprimé(e) avec success !!!'
                    ];
                    return new JsonResponse($data, 201);
            }

            /**
             * @Route("/edite_cy/{id}", methods={"PUT"})
             */
            public function update($id,Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
            {
                $userUpdate = $entityManager->getRepository(Cycle::class)->find($id);
                
                $data =json_decode($request->getContent());
        
                //  $mat =$serializer->deserialize($request->getContent(), Cycle::class, 'json');

                $errors = $validator->validate($userUpdate);
                if(count($errors)) {
                    $errors = $serializer->serialize($errors, 'json');
                    return new Response($errors, 500, [
                        'Content-Type' => 'application/json'
                    ]);
                }
            
                $userUpdate->setLibelle(strtoupper($data->libelle));
                $entityManager->persist($userUpdate);
                $entityManager->flush();
                $data = [
                    'status' => 200,
                    'message' => 'Cycle  Modifié avec success'
                ];
                return new JsonResponse($data);
            }

}
