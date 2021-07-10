<?php

namespace App\Controller;

use App\Entity\Appreciations;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/api")
 */
class AppreciationsController extends AbstractController
{
    /**
     * @Route("/AppByVal/{val}", methods={"GET"})
     */

    public function Frais($val)
    {
        //  $values=json_decode($request->getContent());
        $frai = $this->getDoctrine()->getRepository(Appreciations::class);
        $all = $frai->findAll();
    //    var_dump($all); die;
        foreach($all as $vals)
        {
            
            if($vals->getVal() <= $val && $vals->getValSup() >= $val)
            {
                // dd($vals);
                return $this->json($vals); 
            }
        }
     

    }
}
