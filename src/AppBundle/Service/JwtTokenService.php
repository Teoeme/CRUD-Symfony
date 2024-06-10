<?php
// src/AppBundle/Service/JwtTokenService.php

namespace AppBundle\Service;

use Firebase\JWT\JWT;
use AppBundle\Entity\User;
use Firebase\JWT\Key;
use Psr\Log\LoggerInterface;

class JwtTokenService
{
    private $secretKey;
    private $logger;
    
    public function __construct($secretKey,LoggerInterface $logger)
    {
        $this->secretKey = $secretKey;
        $this->logger = $logger;
    }

    public function createToken(User $user)
    {
        $payload = [
            'username' => $user->getUsername(),
            'name' => $user->getName(),
            'image' => $user->getImage(),
            'roles' => $user->getRoles(),
            'id' => $user->getId(),
            'exp' => (new \DateTime('+1 hour'))->getTimestamp()
        ];
        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function decodeToken($jwtToken)
    {
        try {
            $decoded = JWT::decode($jwtToken, new Key($this->secretKey,'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            throw new \Exception("Invalid token: " . $e->getMessage());
            
        }
    }

}
