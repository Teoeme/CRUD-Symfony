<?php
// src/AppBundle/Security/JwtTokenAuthenticator.php

namespace AppBundle\Security;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JwtTokenAuthenticator extends AbstractGuardAuthenticator
{
    private $userProvider;
    private $jwtSecretKey;
    private $logger;


    public function __construct(UserProviderInterface $userProvider, $jwtSecretKey,LoggerInterface $logger)
    {
        $this->userProvider = $userProvider;
        $this->jwtSecretKey = $jwtSecretKey;
        $this->logger = $logger;
    }

    public function getCredentials(Request $request)
    {
        if (!$token = $request->headers->get('Authorization')) {
            return null;
        }

        if (0 === strpos($token, 'Bearer ')) {
            $token = substr($token, 7);
        }

        return $token;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $this->logger->info('SECRET: ' . $this->jwtSecretKey);
            $this->logger->info('CREDENTIALS: ' . $credentials);
            $decoded = JWT::decode($credentials, new Key($this->jwtSecretKey, 'HS256'));
            $this->logger->info('decoded ' . json_encode($decoded));
            return $this->userProvider->loadUserByUsername($decoded->username);
        } catch (\Exception $e) {
            $this->logger->info('Error ' . $e->getMessage());
            throw new AuthenticationException('Token inválido');
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(['error' => $exception->getMessage()], JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function supportsRememberMe()
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse(['error' => 'Acceso Denegado'], JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function supports(Request $request)
    {
        return $request->headers->has('Authorization');
    }
}
