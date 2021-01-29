<?php

namespace App\Controller;

use App\Entity\Professeur;
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
class ProfesseurController extends AbstractController
{
      /**
     * @Route("/ajouter_prof", methods={"POST"})
     */

    public function new(Request $request,GenererMatP $generer, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {

        
        $users = $this->getUser();

        $prof =$serializer->deserialize($request->getContent(), Professeur::class, 'json');

        //$this-> denyAccessUnlessGranted(['ROLE_SUP_ADMIN','ROLE_ADMIN','ROLE_PARTENAIRE']);

        $errors = $validator->validate($prof);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
            }
            $data =json_decode($request->getContent());
            
            $Gene=strtoupper(substr($prof->getPrenom(),0,1).substr($prof->getNom(),0,1).
            date_format($prof->getDatenessaince(),'Y'));

            
            
            $prof->setMatriculeP( $Gene.$generer->generer());
            $prof->setPrenom(strtoupper($data->prenom));
            $prof->setNom(strtoupper($data->nom));
            $prof->setAdressePr(strtoupper($data->adressePr));
            $prof->setDatenessaince($prof->getDatenessaince());
            $prof->setTelPr($data->telPr);
            $prof->setLieunessaince(strtoupper($data->lieunessaince));
            // $prof->setMats($prof->getMats());

            $entityManager->persist($prof);
            $entityManager->flush();

            $data = [
                'status' => 201,
                'message' => 'Professuer '.$prof->getPrenom().' Ajoute(é) avec succes Sous Le Matirucle '.
                $prof->getMatriculeP()
            ];
            return new JsonResponse($data, 200);
    }

            /**
             * @Route("/getProf/{id}",  methods={"GET"})
             */
            public function getById($id, EntityManagerInterface $entityManager)
            {
                $profUpdate = $entityManager->getRepository(Professeur::class)->find($id);
                
                
                
                return $this->json($profUpdate, 200);
          
            }

             /**
             * @Route("/delete_prof/{id}", methods={"DELETE"})
             */

            public function delete($id)
            {
                $users = $this->getUser();

                $rep = $this->getDoctrine()->getRepository(Professeur::class);
                // $status='';
                $prof=$rep->find($id);
                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->remove($prof);
                $entityManager->flush();
                $data = [
                    'status' => 201,
                    'message' => 'Professeur supprimé(e) avec success !!!'
                    ];
                    return new JsonResponse($data, 201);
            }

            /**
             * @Route("/edite_prof/{id}", methods={"PUT"})
             */
            public function update($id,Request $request,GenererMatP $generer, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
            {
                $userUpdate = $entityManager->getRepository(Professeur::class)->find($id);
                
                $data =json_decode($request->getContent());
                

                
                 
                //  $prof =$serializer->deserialize($request->getContent(), Professeur::class, 'json');

                $errors = $validator->validate($userUpdate);
                if(count($errors)) {
                    $errors = $serializer->serialize($errors, 'json');
                    return new Response($errors, 500, [
                        'Content-Type' => 'application/json'
                    ]);
                }
                //  dd($userUpdate->getMats()[0]);
                $userUpdate->setPrenom(strtoupper($data->prenom));
                // $userUpdate->setMats([$userUpdate->getMats()]);
               
                $userUpdate->setNom(strtoupper($data->nom));
                $userUpdate->setAdressePr(strtoupper($data->adressePr));
                $userUpdate->setTelPr(strtoupper($data->telPr));
                $userUpdate->setDatenessaince($userUpdate->getDatenessaince());
                $userUpdate->setLieunessaince(strtoupper($data->lieunessaince));
                $Gene=strtoupper(substr($userUpdate->getPrenom(),0,1).substr($userUpdate->getNom(),0,1).
                date_format($userUpdate->getDatenessaince(),'Y'));
                $userUpdate->setMatriculeP($Gene.$generer->generer());

                
               $entityManager->persist($userUpdate);
                $entityManager->flush();
                $data = [
                    'status' => 200,
                    'message' => 'Midification  reussie avec success'
                ];
                return new JsonResponse($data);
            }
}
