<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Repository\ClasseRepository;
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
class ClasseController extends AbstractController
{
   
    /**
     * @Route("/ajouter_classe", methods={"POST"})
     */

    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {

        
        $users = $this->getUser();

        $classe =$serializer->deserialize($request->getContent(), Classe::class, 'json');

        // $this-> denyAccessUnlessGranted(['ROLE_SUP_ADMIN','ROLE_ADMIN','ROLE_PARTENAIRE']);

        $errors = $validator->validate($classe);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
            }
            $data =json_decode($request->getContent());

            $classe->setLibclasse(strtoupper($data->libclasse));
            $entityManager->persist($classe);
            $entityManager->flush();

            $data = [
                'status' => 201,
                'message' => $classe->getLibclasse().' cree avec succes'
            ];
            return new JsonResponse($data, 200);
      

    }

            


            /**
             * @Route("/getClasse/{id}",  methods={"GET"})
             */
            public function getById($id, EntityManagerInterface $entityManager)
            {
                $classeUpdate = $entityManager->getRepository(Classe::class)->find($id);
                
                
                
                return $this->json($classeUpdate, 200);
          
            }

             /**
             * @Route("/delete_classe/{id}", methods={"DELETE"})
             */

            public function delete($id)
            {
                $users = $this->getUser();

                $rep = $this->getDoctrine()->getRepository(Classe::class);
                // $status='';
                $classe=$rep->find($id);
              $nb=count($classe->getEleves());
            //   dd($nb);
            if ($nb>=1) {
                $data = [
                    'status' => 201,
                    'message' => 'Imposible de supprimer La '.$classe->getLibclasse().' car elle contient au mois un eleve !!!'
                    ];
                    return new JsonResponse($data, 201);
            }else{
                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->remove($classe);
                $entityManager->flush();
                $data = [
                    'status' => 201,
                    'message' => 'Classe '.$classe->getLibclasse().' supprimée avec success !!!'
                    ];
                    return new JsonResponse($data, 201);
            }
               
                
            }


            /**
             * @Route("/edite_classe/{id}", methods={"PUT"})
             */
            public function update($id,Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
            {
                $userUpdate = $entityManager->getRepository(Classe::class)->find($id);
                
                $data =json_decode($request->getContent());
                

                
        //    dd($data);
                 $user =$serializer->deserialize($request->getContent(), Classe::class, 'json');

                $errors = $validator->validate($userUpdate);
                if(count($errors)) {
                    $errors = $serializer->serialize($errors, 'json');
                    return new Response($errors, 500, [
                        'Content-Type' => 'application/json'
                    ]);
                }
                $userUpdate->setLibclasse(strtoupper($data->libclasse));
                $userUpdate->setCycles($user->getCycles());
               
                $entityManager->persist($userUpdate);
                $entityManager->flush();
                $data = [
                    'status' => 200,
                    'message' => 'La Classe '.$userUpdate->getLibclasse().' Modifié avec success'
                ];
                return new JsonResponse($data);
            }
}
