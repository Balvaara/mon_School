<?php

namespace App\Generateur;

use App\Entity\Compte;
use App\Repository\EleveRepository;
use App\Repository\CompteRepository;
use App\Repository\SemestreRepository;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class GenererNumS{

    private $numero;


    public function __construct(SemestreRepository $CompteRepository)
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
        $indece='SEM';
    

        $date=new \DateTime();

        return $indece.date_format($date, 'Y').$this->numero;
    }
}