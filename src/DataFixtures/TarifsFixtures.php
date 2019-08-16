<?php

namespace App\DataFixtures;

use App\Entity\Tarifs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TarifsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $limiteinf=array(1,501,1001,1101,101,2001,3001,5001,6001,10001,12001,15001,17001,20001,25001,30001,35001,40001,50001,60001,70001,75001,100001,125001,150001);
        $limitesup=array(500,1000,1100,1500,2000,3000,5000,6000,10000,12000,15000,17000,20000,25000,30000,35000,40000,50000,60000,70000,75000,100000,125000,150000,175000);
        $valeur=array(50,100,100,100,200,200,400,600,600,900,900,1000,1000,1500,1500,1500,1800,1800,2000,2700,2700,3000,3600,3800,3800);
        
        
        for ($i=0;$i<count($limiteinf);$i++){
            $tarifs=new Tarifs();
            $tarifs->setLimiteInf($limiteinf[$i]);
            $tarifs->setLimiteSup($limitesup[$i]);
            $tarifs->setFrais($valeur[$i]);
            $manager->persist($tarifs);
        }

        $manager->flush();
    }
}
