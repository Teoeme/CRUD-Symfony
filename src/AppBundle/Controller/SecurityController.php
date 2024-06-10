<?php
// src/AppBundle/Controller/SecurityController.php
// src/AppBundle/Controller/SecurityController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use AppBundle\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * @Route("/api/login", name="login", methods={"POST"})
     */
    public function loginAction(Request $request)
    {
        $jwtTokenService=$this->get('app.jwt_token_service');
        $logger=$this->get('logger');

        $logger->info('Login action called.');

        $data = json_decode($request->getContent(), true);
        
        $logger->info('Received data: ' . json_encode($data));

        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        $logger->info('Extracted username: ' . $username);
        $logger->info('Extracted password: ' . $password);

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $username]);

        

        if ($user) {
            $logger->info('User found: ' . $user->getUsername());
        } else {
            $logger->info('User not found');
        }

        if (!$user || !$this->get('security.password_encoder')->isPasswordValid($user, $password)) {
            $logger->error('Invalid credentials for username: ' . $username);
            // throw new AuthenticationException('Invalid credentials.');
            return new JsonResponse(['message'=>'Credenciales incorrectas'],Response::HTTP_UNAUTHORIZED);

        }
        if($user->getIsActive()===false){
            return new JsonResponse(['message'=>'Usuario desactivado'],Response::HTTP_UNAUTHORIZED);

        }

        $logger->info('User authenticated successfully.');

        $token = $jwtTokenService->createToken($user);

        $logger->info('Generated JWT token: ' . $token);

        return new JsonResponse(['token' => $token,'message'=>'Login correcto!']);
    }
    
}
