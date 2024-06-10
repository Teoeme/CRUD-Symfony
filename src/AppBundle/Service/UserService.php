<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserService
{
    private $em;
    private $logger;
    private $passwordEncoder;
    private $serializer;
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, UserPasswordEncoder $passwordEncoder,SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->passwordEncoder =$passwordEncoder;
        $this->serializer =$serializer;
    }

    public function addUser($data)
    {
        $userRepo = $this->em->getRepository(User::class);
        
    if ($userRepo->findOneBy(['username' => $data['username']])) {
        throw new \Exception("El nombre de usuario ya está en uso.");
    }

    if ($userRepo->findOneBy(['email' => $data['email']])) {
        throw new \Exception("El email ya está en uso.");
    }

        $user = new User();
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setName($data['name']);
        $user->setRoles(['ROLE_USER']);

        $encodedPassword = $this->passwordEncoder->encodePassword($user, $data['password']);
        $user->setPassword($encodedPassword);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
   

    public function updateUser($userId,$data)
    {
        $user = $this->em->getRepository(User::class)->find($userId);

        if (!$user) {
            throw new \Exception("No existe el usuario a editar.");
        }

        if (isset($data['name'])) {
            $user->setName($data['name']);
        }
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }
    
        if (isset($data['active'])) {
            $user->setIsActive($data['active']);
        }
        if (isset($data['image'])) {
            $user->setImage($data['image']);  
        }
        if (isset($data['roles'])) {
            $user->setRoles($data['roles'][0]); 
        }


        if (isset($data['password']) && !empty($data['password'])) {
            if (!isset($data['oldPassword']) || !$this->passwordEncoder->isPasswordValid($user, $data['oldPassword'])) {
                throw new \Exception("La contraseña actual no es correcta.");
            }
            $encodedPassword = $this->passwordEncoder->encodePassword($user, $data['password']);
            $user->setPassword($encodedPassword);
        }

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function deleteUser($id)
    {
        $user = $this->em->getRepository(User::class)->find($id);
        if (!$user) {
            throw new \Exception("Usuario no encontrado.");
        }

        $this->em->remove($user);
        $this->em->flush();
    }

    public function getAllUsers(){
        $users = $this->em->getRepository(User::class)->findAll();
        $context = SerializationContext::create()->setGroups(['user']);
        $productsArray = $this->serializer->serialize($users, 'json', $context);
        return json_decode($productsArray, true);
    }

   
}
