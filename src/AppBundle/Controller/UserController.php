<?php

namespace AppBundle\Controller;

use Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/api/user", name="user", methods={"GET","POST","PUT","DELETE"})
     */

    public function userAction(Request $request): JsonResponse
    {
        $userService = $this->get('app.user_service');
        switch ($request->getMethod()) {
            case 'POST':
                if (!$this->isGranted('ROLE_SUPER_ADMIN','ROLE_ADMIN')) {
                    return new JsonResponse(['message' => 'No tiene permisos para agregar usuarios.'], JsonResponse::HTTP_FORBIDDEN);
                }
                $data = json_decode($request->getContent(), true);
                try {
                    $user = $userService->addUser($data);
                    return new JsonResponse(['data' => $user,'message'=>'Usuario agregado con éxito'], Response::HTTP_CREATED);
                } catch (\Exception $err) {
                    //throw $th;
                    return new JsonResponse(['message' => $err->getMessage()], Response::HTTP_BAD_REQUEST);
                }

                break;

            case 'PUT':
                $data = json_decode($request->getContent(), true);
                try {
                    $jwtTokenService = $this->get('app.jwt_token_service');

                    $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));
                    $userData = $jwtTokenService->decodeToken($token);

                    if ($data['id'] === $userData['id'] || $this->isGranted(['ROLE_ADMIN','ROLE_SUPER_ADMIN']) || in_array('ROLE_ADMIN', $userData['roles']) || in_array('ROLE_SUPER_ADMIN', $userData['roles'])) {
                      if(!$this->isGranted(['ROLE_SUPER_ADMIN'])){
                        $data['roles']=null;
                      }
                        $user = $userService->updateUser($data['id'], $data);
                        return new JsonResponse(['data' => $user,'message'=>'Usuario editado con éxito!'], Response::HTTP_CREATED);
                    } else {
                        return new JsonResponse(['message' => 'No puede editar este usuario.'], 401);
                    }
                } catch (\Exception $err) {
                    return new JsonResponse(['message' => $err->getMessage()], Response::HTTP_BAD_REQUEST);
                }

                break;

            case 'DELETE':
                try {
                    if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
                        return new JsonResponse(['message' => 'No tiene permisos para eliminar usuarios.'], JsonResponse::HTTP_FORBIDDEN);
                    }
                    $data = json_decode($request->getContent(), true);
                    $user = $userService->deleteUser($data['id']);
                    return new JsonResponse(['data' => $user, 'message' => "Usuario eliminado con éxito "], Response::HTTP_CREATED);
                } catch (Exception $err) {
                    //throw $th;
                    return new JsonResponse(['message' => "Error al eliminar el usuario", "data" => $err->getMessage()], 400);
                }
                break;


            default:
                # code...
                return new JsonResponse(['message' => 'Método no permitido'], Response::HTTP_METHOD_NOT_ALLOWED);

                break;
        }
    }

    /**
     * @Route("/api/users", name="users", methods={"GET"})
     */

    public function usersAction(Request $request): JsonResponse
    {
        $userService = $this->get('app.user_service');
        $users = $userService->getAllUsers();
        return new JsonResponse($users);
    }

    /**
     * @Route("/api/getuser", name="getuser", methods={"GET"})
     */
    public function getCurrentUser(Request $request):JsonResponse
    {
       
        try {
            $jwtTokenService = $this->get('app.jwt_token_service');

            $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));
            $userData = $jwtTokenService->decodeToken($token);

                return new JsonResponse(['data' => $userData], Response::HTTP_CREATED);

        } catch (\Exception $err) {
            return new JsonResponse(['message' => $err->getMessage()], Response::HTTP_BAD_REQUEST);
        }


    }

}
