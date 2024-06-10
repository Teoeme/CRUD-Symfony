<?php
namespace AppBundle\Controller;

use AppBundle\Service\AttributeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class AttributeController extends Controller
{
    /**
     * @Route("/api/attributes", name="attributes")
     */
    public function atributesAction(Request $request): JsonResponse
    {
        $attributeService=$this->get('app.attribute_service');
       switch ($request->getMethod()){
        case 'GET':
            try {
               $attributes= $attributeService->getAllAttributes();

                return new JsonResponse(["message"=>"Atributos obtenidos","data"=>$attributes],Response::HTTP_OK);
                } catch (\Throwable $th) {
                return new JsonResponse(["message"=>"Error al obtener atributos"],Response::HTTP_BAD_REQUEST);
                //throw $th;
            }

            
            break;
        
        default:
            # code...
            break;
       } 
    }


}