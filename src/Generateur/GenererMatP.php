<?php

namespace App\Generateur;


use App\Repository\ProfesseurRepository;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class GenererMatP{

    private $numero;


    public function __construct(ProfesseurRepository $CompteRepository)
    {
      

        $last=$CompteRepository->findOneBy([],['id'=>'desc']);

        if ($last!=null) {

            $lastId=$last->getId();

            $this->numero=sprintf("%'.02d",$lastId +1);
        }
        else{
            $this->numero=sprintf("%'.02d",1);
        }

    }

    public function generer(){
        // $indece='PRO';
    

        // $date=new \DateTime();

        return $this->numero;
    }
}