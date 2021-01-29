<?php

namespace App\DataFixtures;
// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture 
{
    private $encoder;
 
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {  
        $faker = Faker\Factory::create('fr_FR');

        $dir=new Role();
        $dir->setLibelle("DIRECTEUR");
        $manager->persist($dir);

        $trs=new Role();
        $trs->setLibelle("TRESORIER");
        $manager->persist($trs);

        $sur=new Role();
        $sur->setLibelle("SURVEILLANT");
        $manager->persist($sur);




        $manager->flush();
     

        $this->addReference('role_directeur',$dir);
        $this->addReference('role_tresorier',$trs);
        $this->addReference('role_surveillant',$sur);
       

        $roleSupAd=$this->getReference('role_directeur');
        $roleAd=$this->getReference('role_tresorier');
        $roleCais=$this->getReference('role_surveillant');
      



        $user = new User();
        $user->setPrenom('Lamine');
        $user->setNom('Mbaye');

        $user->setUsername('lamine@gmail.com');
        $user->setPassword($this->encoder->encodePassword($user, "passer"));
        $user->setRoles(["ROLE_".$dir->getLibelle()]);
        $user->setProfil($dir);
        // $user->setPartenaire(null);

         $user->setIsActive(true);


        $manager->persist($user);
        $manager->flush();
    }
   
}