<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Superadmin extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setusername("kim");
        $user->setRoles(["ROLE_SUPERADMIN"]);
        $password = $this->encoder->encodePassword($user, 'entrer');
        $user->setPassword($password);
        $user->setEtatU("actif");
        $user->setAdresseU("dieuppeul 2");
        $user->setNom("ndiaye");
        $user->setPrenom("mama guisse");

        $manager->persist($user);
        

        $manager->flush();
    }
}
