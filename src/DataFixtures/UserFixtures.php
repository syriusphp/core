<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Syrius\UserBundle\Entity\User;

class UserFixtures extends Fixture implements ContainerAwareInterface
{
    const USER_MANAGER = 'fos_user.user_manager';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var UserManager
     */
    private $userManager;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->userManager = $this->container->get(static::USER_MANAGER);
    }


    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user
            ->setEnabled(true)
            ->setRoles(array(User::ROLE_SUPER_ADMIN))
            ->setUsername("admin")
            ->setPlainPassword("admin")
            ->setEmail("admin@gmail.com")
        ;

        $this->userManager->updateUser($user);
    }
}
