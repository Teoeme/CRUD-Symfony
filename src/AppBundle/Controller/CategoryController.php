<?php

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller{
    /**
    * @Route("/api/category", name="category", methods={"GET","POST","PUT","DELETE"})
    */

    public function categoryAction(Request $request):JsonResponse
    {
        $categoryService=$this->get('app.category_service');
        switch ($request->getMethod()) {
            case 'POST':
                if (!$this->isGranted(['ROLE_ADMIN','ROLE_SUPER_ADMIN'])) {
                    return new JsonResponse(['message' => 'No tiene permisos para agregar categorías.'], JsonResponse::HTTP_FORBIDDEN);
                }
                $data=json_decode($request->getContent(),true);
                try {
                    $category=$categoryService->addCategory($data);
                    return new JsonResponse(['data'=>$category,'message'=>'Categoría agregada con éxito'],Response::HTTP_CREATED);
                } catch (\Exception $err) {
                    //throw $th;
                    return new JsonResponse(['message' => $err->getMessage()], Response::HTTP_BAD_REQUEST);
                }

                break;

            case 'PUT':
                $data=json_decode($request->getContent(),true);
                try {
                    if (!$this->isGranted(['ROLE_ADMIN','ROLE_SUPER_ADMIN'])) {
                        return new JsonResponse(['message' => 'No tiene permisos para editar categorías.'], JsonResponse::HTTP_FORBIDDEN);
                    }
                    $category=$categoryService->updateCategory($data);
                    return new JsonResponse(['data'=>$category,'message'=>'Categoría editada con éxito'],Response::HTTP_OK);

                } catch (\Exception $err) {
                    return new JsonResponse(['message' => $err->getMessage()], Response::HTTP_BAD_REQUEST);
                    
                }

            break;
                
            case 'DELETE':
                $data=json_decode($request->getContent(),true);
                try {
                    if (!$this->isGranted(['ROLE_ADMIN','ROLE_SUPER_ADMIN'])) {
                        return new JsonResponse(['message' => 'No tiene permisos para eliminar categorías.'], JsonResponse::HTTP_FORBIDDEN);
                    }
                    $category=$categoryService->deleteCategory($data['id']);
                    return new JsonResponse(['data'=>$category,'message'=>'Categoría eliminada con éxito'],Response::HTTP_OK);

                } catch (\Exception $err) {
                    return new JsonResponse(['message' => $err->getMessage()], Response::HTTP_BAD_REQUEST);
                    
                }

            break;
                
            default:
                # code...
                return new JsonResponse(['message' => 'Método no permitido'], Response::HTTP_METHOD_NOT_ALLOWED);

                break;
        }

    }

       /**
    * @Route("/api/categories", name="categories", methods={"GET","POST","PUT","DELETE"})
    */
    public function categoriesActions(Request $request):JsonResponse
    {
        $categoryService=$this->get('app.category_service');
        switch ($request->getMethod()) {
            case 'GET':
                $products = $categoryService->getAllCategories();
                return new JsonResponse($products);
                break;
            
            default:
                # code...
                break;
        }
    }

}