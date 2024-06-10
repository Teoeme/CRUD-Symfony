<?php

namespace AppBundle\Controller;

use AppBundle\Service\ProductService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
 
    /**
     * @Route("/api/product", methods={"GET", "POST", "PUT", "DELETE"})
     */
    public function productAction(LoggerInterface $logger = null,Request $request): JsonResponse
    {
        $logger = $this->get('logger');
        $productService = $this->get('app.product_service');

        switch ($request->getMethod()) {
            case 'GET':
                // Lógica para obtener un producto
                $value = $request->query->get('id') ?? $request->query->get('name');
                
                try {
                    $product = $productService->getProduct($value);
                    $logger->info(json_encode('Producto encontrado: ' . json_encode($product)));
                    return new JsonResponse(['data' => $product], Response::HTTP_OK);
                } catch (\Exception $e) {
                    return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
                }
                break;
            case 'POST':
                    // Lógica para crear un producto
                    if (!$this->isGranted(['ROLE_ADMIN','ROLE_SUPER_ADMIN'])) {
                        return new JsonResponse(['message' => 'No tiene permisos para agregar productos.'], JsonResponse::HTTP_FORBIDDEN);
                    }
                    $data= json_decode($request->getContent(),true);
                    $product = $productService->addProduct($data);
                    return new JsonResponse(['data'=>$product,'message'=>'Producto agregado con éxito'],Response::HTTP_CREATED);
                break;
            case 'PUT':
                // Lógica para actualizar un producto
                if (!$this->isGranted(['ROLE_ADMIN','ROLE_SUPER_ADMIN'])) {
                    return new JsonResponse(['message' => 'No tiene permisos para editar productos.'], JsonResponse::HTTP_FORBIDDEN);
                }
                try {
                    if (!$this->isGranted(['ROLE_ADMIN','ROLE_SUPER_ADMIN'])) {
                        return new JsonResponse(['error' => 'No tiene permisos para editar productos.'], JsonResponse::HTTP_FORBIDDEN);
                    }
                    $data= json_decode($request->getContent(),true);
                    $productService->updateProduct($data['id'],$data);
                    return new JsonResponse(['message' => 'Producto editado con éxito.'], Response::HTTP_OK);
                } catch (\Exception $err) {
                    return new JsonResponse(['message' => $err->getMessage()], Response::HTTP_BAD_REQUEST);
                }
                
                break;
            case 'DELETE':
                // Lógica para eliminar un producto

                try {
                    if (!$this->isGranted(['ROLE_ADMIN','ROLE_SUPER_ADMIN'])) {
                        return new JsonResponse(['message' => 'No tiene permisos para eliminar productos.'], JsonResponse::HTTP_FORBIDDEN);
                    }
                    $data= json_decode($request->getContent(),true);
                    $productService->deleteProduct($data['id']);
                    return new JsonResponse(['message' => 'Producto eliminado con éxito.'], Response::HTTP_OK);
                } catch (\Exception $err) {
                    return new JsonResponse(['message' => $err->getMessage()], Response::HTTP_BAD_REQUEST);
                }
                
                break;
            default:
                // Retornar una respuesta de método no permitido si es necesario
                return new JsonResponse(['message' => 'Method Not Allowed'], Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }
    
     
      /**
     * @Route("/api/products", methods={"GET", "POST", "PUT", "DELETE"})
     */
    
    public function productsAction(Request $request): JsonResponse
    {
        // Determinar el tipo de solicitud
        $productService = $this->get('app.product_service');
        switch ($request->getMethod()) {
            case 'GET':
                // Lógica para obtener un producto
                $products = $productService->getAllProducts();
                return new JsonResponse($products);
                break;
            case 'POST':
                // Lógica para crear un producto
                break;
            case 'PUT':
                // Lógica para actualizar un producto
                break;
            case 'DELETE':
                // Lógica para eliminar un producto
                break;
            default:
                // Retornar una respuesta de método no permitido si es necesario
                return new JsonResponse(['message' => 'Method Not Allowed'], Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }

      /**
     * @Route("/api/public/products", methods={"GET", "POST", "PUT", "DELETE"})
     */
    
     public function productsPublicAction(Request $request): JsonResponse
     {
         // Determinar el tipo de solicitud
         $productService = $this->get('app.product_service');
         switch ($request->getMethod()) {
             case 'GET':
                 // Lógica para obtener un producto
                 $products = $productService->getAllProductsPublic();
                 return new JsonResponse($products);
                 break;
             case 'POST':
                 // Lógica para crear un producto
                 break;
             case 'PUT':
                 // Lógica para actualizar un producto
                 break;
             case 'DELETE':
                 // Lógica para eliminar un producto
                 break;
             default:
                 // Retornar una respuesta de método no permitido si es necesario
                 return new JsonResponse(['message' => 'Method Not Allowed'], Response::HTTP_METHOD_NOT_ALLOWED);
         }
     }
    
}
