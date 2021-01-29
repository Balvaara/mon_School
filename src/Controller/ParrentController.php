<?php

namespace App\Controller;

use App\Entity\Parrent;
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
class ParrentController extends AbstractController
{
             /**
             * @Route("/listparrents/{id}", methods={"GET"})
             */
            public function getById($id, EntityManagerInterface $entityManager)
            {
                $eleveUpdate = $entityManager->getRepository(Parrent::class)->find($id);
                
                
                
                return $this->json($eleveUpdate, 200);
          
            }




            /**
             * @Route("/listParrent", methods={"GET"})
            */
            public function getCompte()
            {
                
                $repo = $this->getDoctrine()->getRepository(Parrent::class);
                $compte = $repo->findAll();
                
                $data = [];
                $i= 0;
                
     
                    foreach($compte as $comptes)
                    {
                        
                            $data[$i]=$comptes;
                            $i++;
                        
                        
                    }
       
                         
                 return $this->json($data, 200);
                // }
           
            
        
   
            }


            /**
             * @Route("/edite_parrent/{id}", methods={"PUT"})
             */
            public function update($id,Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
            {
                $userUpdate = $entityManager->getRepository(Parrent::class)->find($id);
                
                $data =json_decode($request->getContent());
                

                
        //    dd($data);
                 $user =$serializer->deserialize($request->getContent(), Parrent::class, 'json');

                $errors = $validator->validate($userUpdate);
                if(count($errors)) {
                    $errors = $serializer->serialize($errors, 'json');
                    return new Response($errors, 500, [
                        'Content-Type' => 'application/json'
                    ]);
                }
                $userUpdate->setPrenomP(strtoupper($data->prenomP));
                $userUpdate->setNomP(strtoupper($data->nomP));
                $userUpdate->setAdresse(strtoupper($data->adresse));
                $userUpdate->setTel(strtoupper($data->tel));
             


                $entityManager->persist($userUpdate);
                $entityManager->flush();
                $data = [
                    'status' => 200,
                    'message' => 'Midification  reussie avec success'
                ];
                return new JsonResponse($data);
            }

}
