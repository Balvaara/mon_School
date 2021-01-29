<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Eleve;
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
class NoteController extends AbstractController
{
    public function Matricule($matricule)
    {
     
        $eleve = $this->getDoctrine()->getRepository(Eleve::class);
        $all = $eleve->findAll();
        //  dd($partenaire); die;
         foreach ($all as  $value)
            {
            if ($matricule==$value->getMatricule()){
               
                return true;
            }
            }
        
     }

     /**
     * @Route("/ajout_note", methods={"POST"})
     */
   public function new(Request $request, SerializerInterface $serializer,EntityManagerInterface $entityManager, ValidatorInterface $validator)
   {
    // $this-> denyAccessUnlessGranted(['ROLE_SUP_ADMIN','ROLE_ADMIN']);
         //utilisateur qui connecte
         $users= $this->getUser();

         $date=new \DateTime();

         $note = $serializer->deserialize($request->getContent(), Note::class, 'json');
        //  $depot = $serializer->deserialize($request->getContent(), Depot::class, 'json');

       $val = json_decode($request->getContent());

       $errors = $validator->validate($note);
       if(count($errors)) {
           $errors = $serializer->serialize($errors, 'json');
           return new Response($errors, 500, [
               'Content-Type' => 'application/json'
           ]);
       }

       if( $this->Matricule($val->matricule)==true)
       {
        $part =$this->getDoctrine()->getRepository(Eleve::class);
        $ligneEleve=$part->findOneByMatricule($val->matricule);
        //  dd($ligneEleve->getNom());
        $note->setEleves($ligneEleve);
        $entityManager->persist($note);
        $entityManager->flush();
        // dd($ligneEleve);
              
            $data = [
                'status' => 201,
                'message' => 'Note '. $note->getValeur().
                ' est attribuée à l\'eleve '.$note->getEleves()->getPrenom().' '.
                $note->getEleves()->getNom().
                 ' Pour La Matiere: '.$note->getMatieres()->getLibelle().' Au Semestre : '
                 .$note->getSems()->getLibellesemestre()
            ];
            return new JsonResponse($data, 200);

       }

            $data = [
                'status' => 500,
                'message' => 'Desolé Cet eleve N\'existe Pas'
            ];
            return new JsonResponse($data, 200);

    }

            /**
             * @Route("/edite_Note/{id}", methods={"PUT"})
             */
            public function update($id,Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
            {
                $userUpdate = $entityManager->getRepository(Note::class)->find($id);
                
                $data =json_decode($request->getContent());
          

                $errors = $validator->validate($userUpdate);
                if(count($errors)) {
                    $errors = $serializer->serialize($errors, 'json');
                    return new Response($errors, 500, [
                        'Content-Type' => 'application/json'
                    ]);
                }
                $userUpdate->setValeur(strtoupper($data->valeur));
               


                $entityManager->persist($userUpdate);
                $entityManager->flush();
                $data = [
                    'status' => 200,
                    'message' => 'Midification  reussie avec success'
                ];
                return new JsonResponse($data);
            }


          /**
             * @Route("/getNote/{id}",  methods={"GET"})
             */
            public function getById($id, EntityManagerInterface $entityManager)
            {
                $eleveUpdate = $entityManager->getRepository(Note::class)->find($id);
                
                
                
                return $this->json($eleveUpdate, 200);
          
            }


            /**
             *@Route("/getNoteByMat/{matricule}", methods={"GET"})
            */
            public function getUsers($matricule)
            {
                
                $repo = $this->getDoctrine()->getRepository(Note::class);
                $notes = $repo->findAll();
               
                
                $data = [];
                $i= 0;
                $ucsercon =$this->getUser();
                //dd($ucsercon);
                
                    foreach($notes as $note)
                    {
                        if ($note->getEleves()->getMatricule()==$matricule) {

                            $data[$i]=$note;
                            $i++;   
                        }
                    }
                return $this->json($data, 201);
            }
            /**
             *@Route("/getNoteByMatSem/{matricule}/{sem}", methods={"GET"})
            */
            public function getNote($matricule,$sem)
            {
                
                $repo = $this->getDoctrine()->getRepository(Note::class);
                $notes = $repo->findAll();
               
                
                $data = [];
                $i= 0;
                $ucsercon =$this->getUser();
                //dd($ucsercon);
                
                    foreach($notes as $note)
                    {
                        if ($note->getEleves()->getMatricule()==$matricule 
                        && $note->getSems()->getId()==$sem  ) {

                            $data[$i]=$note;
                            $i++;   
                        }
                    }
                return $this->json($data, 201);
            }
            
            /**
             *@Route("/getMoy/{matricule}/{sem}", methods={"GET"})
            */
            public function Moy($matricule,$sem)
            {
                
                $repo = $this->getDoctrine()->getRepository(Note::class);
                $notes = $repo->findAll();
               $generCoef=$this->TotalCoef($matricule,$sem);

               $generNP=$this->TotalMoyPart($matricule,$sem);
            //    dd($generNP);
                $somme=0;
                $coef=0;
                $data = 0;
                $moy= 0;
                $ucsercon =$this->getUser();
                //dd($ucsercon);
                
                    foreach($notes as $note)
                    {
                        if ($note->getEleves()->getMatricule()==$matricule 
                        && $note->getSems()->getId()==$sem  ) {

                            $data= $generNP/$generCoef;
                        }
                    }
                return $this->json($data, 201);
            }


            /**
             *@Route("/getSomme/{matricule}/{sem}", methods={"GET"})
            */
            public function Somme($matricule,$sem)
            {
                
                $repo = $this->getDoctrine()->getRepository(Note::class);
                $notes = $repo->findAll();
               
                $somme=0;
             
                $ucsercon =$this->getUser();
                //dd($ucsercon);
                
                    foreach($notes as $note)
                    {
                        if ($note->getEleves()->getMatricule()==$matricule 
                        && $note->getSems()->getId()==$sem  ) {

                           
                            $somme=$somme+$note->getValeur();
                        }
                    }

                    //  dd($somme);
                    
                
                
                return $this->json($somme, 201);
            }

            /**
             *@Route("/getCoef/{matricule}/{sem}", methods={"GET"})
            */
            public function Coef($matricule,$sem)
            {
                
                $repo = $this->getDoctrine()->getRepository(Note::class);
                $notes = $repo->findAll();
               
                $coef=0;
             
                $ucsercon =$this->getUser();
                //dd($ucsercon);
                
                    foreach($notes as $note)
                    {
                        if ($note->getEleves()->getMatricule()==$matricule 
                        && $note->getSems()->getId()==$sem  ) {

                           
                            $coef=$coef+$note->getMatieres()->getCoef();
                        }
                    }

                    //  dd($coef);
                    
                
                
                return $this->json($coef, 201);
            }

            /**
             *@Route("/getSommeNC/{matricule}/{sem}", methods={"GET"})
            */
            public function getSommeNC($matricule,$sem)
            {
                
                $repo = $this->getDoctrine()->getRepository(Note::class);
                $notes = $repo->findAll();
               
                $coef=0;
                $somme=0;
             
                $ucsercon =$this->getUser();
                //dd($ucsercon);
                
                    foreach($notes as $note)
                    {
                        if ($note->getEleves()->getMatricule()==$matricule 
                        && $note->getSems()->getId()==$sem  ) {

                           
                            $coef=$note->getMatieres()->getCoef()*$note->getValeur();
                            $somme=$somme+$coef;
                        }
                    }

                    //  dd($coef);
                    
                
                
                return $this->json($somme, 201);
            }


            /**
             *@Route("/getMoyPart/{matricule}/{sem}", methods={"GET"})
            */
            public function MoyPart($matricule,$sem)
            {
                
                $repo = $this->getDoctrine()->getRepository(Note::class);
                $notes = $repo->findAll();
               
                $coef=0;
                $somme=0;
                $data=0;
                $ucsercon =$this->getUser();
                //dd($ucsercon);
                
                    foreach($notes as $note)
                    {
                        if ($note->getEleves()->getMatricule()==$matricule 
                        && $note->getSems()->getId()==$sem  ) {

                           
                            $data=$note->getValeur()*$note->getMatieres()->getCoef();

                            $coef=$data/$note->getMatieres()->getCoef();

                            $somme=$somme+$coef;
                        }
                    }

                    //   dd($somme);
                    
                
                
                return $this->json($somme, 201);
            }


            public function TotalMoyPart($matricule,$sem)
            {
                
                $repo = $this->getDoctrine()->getRepository(Note::class);
                $notes = $repo->findAll();
               
                $coef=0;
                $somme=0;
                $data=0;
                $ucsercon =$this->getUser();
                //dd($ucsercon);
                
                    foreach($notes as $note)
                    {
                        if ($note->getEleves()->getMatricule()==$matricule 
                        && $note->getSems()->getId()==$sem  ) {

                           
                            $data=$note->getValeur()*$note->getMatieres()->getCoef();

                            $coef=$data/$note->getMatieres()->getCoef();

                            $somme=$somme+$coef;
                        }
                    }

                    //   dd($somme);
                    
                
                
                return $somme;
            }


            public function TotalCoef($matricule,$sem)
            {
                
                $repo = $this->getDoctrine()->getRepository(Note::class);
                $notes = $repo->findAll();
               
                $coef=0;
             
                $ucsercon =$this->getUser();
                //dd($ucsercon);
                
                    foreach($notes as $note)
                    {
                        if ($note->getEleves()->getMatricule()==$matricule 
                        && $note->getSems()->getId()==$sem  ) {

                           
                            $coef=$coef+$note->getMatieres()->getCoef();
                        }
                    }

                    //  dd($coef);
                    
                
                
                return $coef;
            }
            
   	
}
