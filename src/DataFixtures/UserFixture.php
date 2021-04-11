<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('psobczak');
        $password = $this->encoder->encodePassword($user1, "psobczak2138!");
        $user1->setPassword($password);
        $user1->setName("Piotr Sobczak");
        $user1->setJoinDate(new \DateTime());
        $user1->setRoles(["ROLE_FULL"]);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('mdebowski');
        $password = $this->encoder->encodePassword($user2, "mdebowski2139!");
        $user2->setPassword($password);
        $user2->setName("Michał Dębowski");
        $user2->setJoinDate(new \DateTime());
        $user2->setRoles(["ROLE_RESTRICTED"]);
        $manager->persist($user2);

        $manager->flush();
    }
}
