<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Generateur\GenererMatP;
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
class MatiereController extends AbstractController
{
   
    /**
     * @Route("/ajouter_Mat", methods={"POST"})
     */

    public function new(Request $request,GenererMatP $generer, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {

        
        $users = $this->getUser();

        $mat =$serializer->deserialize($request->getContent(), Matiere::class, 'json');

        $data =json_decode($request->getContent());
        $errors = $validator->validate($mat);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
            }
            $mat->setLibelle(strtoupper($data->libelle));
            $mat->setCoef($data->coef);
            $entityManager->persist($mat);
            $entityManager->flush();

            $data = [
                'status' => 201,
                'message' =>'Matiere '. $mat->getLibelle().' Ajouté avec succes'
            ];
            return new JsonResponse($data, 200);
    }

            /**
             * @Route("/getMat/{id}", name="parId", methods={"GET"})
             */
            public function getById($id, EntityManagerInterface $entityManager)
            {
                $classeUpdate = $entityManager->getRepository(Matiere::class)->find($id);
                
                
                
                return $this->json($classeUpdate, 200);
          
            }

             /**
             * @Route("/delete_mat/{id}", methods={"DELETE"})
             */

            public function delete($id)
            {
                $users = $this->getUser();

                $rep = $this->getDoctrine()->getRepository(Matiere::class);
                // $status='';
                $mat=$rep->find($id);
                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->remove($mat);
                $entityManager->flush();
                $data = [
                    'status' => 201,
                    'message' => 'Matiere supprimé(e) avec success !!!'
                    ];
                    return new JsonResponse($data, 201);
            }

            /**
             * @Route("/edite_mat/{id}", methods={"PUT"})
             */
            public function update($id,Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
            {
                $userUpdate = $entityManager->getRepository(Matiere::class)->find($id);
                
                $data =json_decode($request->getContent());
                

                
        //    dd($data);
                 $mat =$serializer->deserialize($request->getContent(), Matiere::class, 'json');

                $errors = $validator->validate($userUpdate);
                if(count($errors)) {
                    $errors = $serializer->serialize($errors, 'json');
                    return new Response($errors, 500, [
                        'Content-Type' => 'application/json'
                    ]);
                }
             ;
                $userUpdate->setLibelle(strtoupper($data->libelle));
                $userUpdate->setCoef($data->coef);


                $entityManager->persist($userUpdate);
                $entityManager->flush();
                $data = [
                    'status' => 200,
                    'message' => 'Matiere  Modifié avec success'
                ];
                return new JsonResponse($data);
            }
}
