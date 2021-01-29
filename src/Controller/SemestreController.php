<?php

namespace App\Controller;

use App\Entity\Semestre;
use App\Generateur\GenererNumS;
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
class SemestreController extends AbstractController
{
      /**
     * @Route("/ajouter_semestre", methods={"POST"})
     */

    public function new(Request $request,GenererNumS $generer, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {

        
        $users = $this->getUser();

        $semestre =$serializer->deserialize($request->getContent(), Semestre::class, 'json');

        // $this-> denyAccessUnlessGranted(['ROLE_SUP_ADMIN','ROLE_ADMIN','ROLE_PARTENAIRE']);

        $errors = $validator->validate($semestre);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
            }
            $data =json_decode($request->getContent());
            $semestre->setLibellesemestre(strtoupper($data->libellesemestre));
            $semestre->setNumsemestre($generer->generer());
            $entityManager->persist($semestre);
            $entityManager->flush();

            $data = [
                'status' => 201,
                'message' => $semestre->getLibellesemestre().' cree avec succes'
            ];
            return new JsonResponse($data, 200);
      

    }
}
