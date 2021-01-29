<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Parrent;
use App\Generateur\GenererMtricule;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Foreach_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/api")
 */
class EleveController extends AbstractController
{
     /**
     * @Route("/new_eleve", name="add_eleve", methods={"POST"})
     */

    public function new(Request $request,GenererMtricule $generer, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        // $this-> denyAccessUnlessGranted(['ROLE_SUP_ADMIN','ROLE_ADMIN']);
        
        $users = $this->getUser();
        
        // $values=json_decode($request->getContent());
        $date=new \DateTime('now');
        


         $eleve = $serializer->deserialize($request->getContent(), Eleve::class, 'json');
         $parrent = $serializer->deserialize($request->getContent(), Parrent::class, 'json');
    
        $errors = $validator->validate($eleve);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }

        $data =json_decode($request->getContent());

        $Gene=strtoupper(substr($eleve->getPrenom(),0,1).substr($eleve->getNom(),0,1).
        date_format($eleve->getDateness(),'Y'));


        $Pp = $this->getDoctrine()->getRepository(Parrent::class);
        $Pps = $Pp->findAll();
      

        foreach ($Pps as $myparent ) {
            
          if ($myparent->getPrenomP()==$parrent->getPrenomP()
          && $myparent->getNomP()==$parrent->getNomP() 
          && $myparent->getAdresse()==$parrent->getAdresse()
          && $myparent->getTel()==$parrent->getTel() ) {

            // $EncienParent=$myparent;
        $eleve->setMatricule($Gene.$generer->generer());
        $eleve->setParents($myparent);
        $entityManager->persist($eleve);
        $entityManager->flush();

        $data = [
            'status' => 200,
            'message' => 'Eleve : '.$eleve->getPrenom().' '.$eleve->getNom().
            ' Inscrit avec succes Sous le Matricule '.$eleve->getMatricule()
          ];
        return new JsonResponse($data, 200);
            // dd($EncienParent);

          }
        }
        $parrent->setPrenomP(strtoupper($data->prenomP));
        $parrent->setNomP(strtoupper($data->nomP));
        $parrent->setAdresse(strtoupper($data->adresse));
        $parrent->setTel($data->tel);
        $entityManager->persist($parrent);
        $entityManager->flush();

        $eleve->setMatricule($Gene.$generer->generer());
        $eleve->setPrenom(strtoupper($data->prenom));
        $eleve->setNom(strtoupper($data->nom));
        $eleve->setResidence(strtoupper($data->residence));
        $eleve->setLieuness(strtoupper($data->lieuness));
        $eleve->setParents($parrent);
        $entityManager->persist($eleve);
        $entityManager->flush();

            $data = [
                'status' => 200,
                'message' => 'Eleve : '.$eleve->getPrenom().' '.$eleve->getNom().
                ' Inscrit avec succes Sous le Matricule '.$eleve->getMatricule()
            ];
            return new JsonResponse($data, 200);
                

      
    
    }

             /**
             * @Route("/delete_eleve/{id}", methods={"DELETE"})
             */

            public function delete($id)
            {
                $users = $this->getUser();

                $rep = $this->getDoctrine()->getRepository(Eleve::class);
                // $status='';
                $eleve=$rep->find($id);
                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->remove($eleve);
                $entityManager->flush();
                $data = [
                    'status' => 201,
                    'message' => 'Eleve supprimé avec success !!!'
                    ];
                    return new JsonResponse($data, 201);
            }

            /**
             *@Route("/getMatt/{matricule}", methods={"GET"})
            */
            public function getMat($matricule)
            {
                
                $repo = $this->getDoctrine()->getRepository(Eleve::class);
                $notes = $repo->findAll();
               
                
                $data = [];
                $i= 0;
                $ucsercon =$this->getUser();
                //dd($ucsercon);
                
                    foreach($notes as $note)
                    {
                        if ($note->getMatricule()==$matricule) {

                            $data[$i]=$note;
                            $i++;   
                        }
                       
                        
                     
                    }
                        
                    
                
                
                return $this->json($data, 201);
            }
        


            /**
             * @Route("/getEleve/{id}",  methods={"GET"})
             */
            public function getById($id, EntityManagerInterface $entityManager)
            {
                $eleveUpdate = $entityManager->getRepository(Eleve::class)->find($id);
                
                
                
                return $this->json($eleveUpdate, 200);
          
            }

            /**
             * @Route("/edite_eleve/{id}", methods={"PUT"})
             */
            public function update($id,Request $request,GenererMtricule $generer, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
            {
                $userUpdate = $entityManager->getRepository(Eleve::class)->find($id);
                
                $data =json_decode($request->getContent());
                

                
        //    dd($data);
                 $user =$serializer->deserialize($request->getContent(), Eleve::class, 'json');

                $errors = $validator->validate($userUpdate);
                if(count($errors)) {
                    $errors = $serializer->serialize($errors, 'json');
                    return new Response($errors, 500, [
                        'Content-Type' => 'application/json'
                    ]);
                }
                $userUpdate->setResidence(strtoupper($data->residence));
                $userUpdate->setMyclasses($user->getMyclasses());
                $userUpdate->setLieuness(strtoupper($data->lieuness));
                $userUpdate->setPrenom(strtoupper($data->prenom));
                $userUpdate->setNom(strtoupper($data->nom));
                 $userUpdate->setDateness($user->getDateness());
                 $Gene=strtoupper(substr($userUpdate->getPrenom(),0,1).substr($userUpdate->getNom(),0,1).
                date_format($userUpdate->getDateness(),'Y'));
                $userUpdate->setMatricule($Gene.$generer->generer());


                $entityManager->persist($userUpdate);
                $entityManager->flush();
                $data = [
                    'status' => 200,
                    'message' => 'Midification  reussie avec success'
                ];
                return new JsonResponse($data);
            }

            
}

