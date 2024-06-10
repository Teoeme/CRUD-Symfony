<?php

namespace AppBundle\Service;

use AppBundle\Entity\Attribute;
use AppBundle\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductAttribute;
use AppBundle\Entity\ProductCategory;
use AppBundle\Entity\ProductVariant;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;


class ProductService
{
    private $em;
    private $serializer;

    public function __construct(EntityManagerInterface $em,SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    public function addProduct($data)
    {
        $product = new Product($data);

        $this->addAttributesToProduct($product,$data);
        $this->addCategoriesToProduct($product,$data);

        $this->em->persist($product);
        $this->em->flush();


        if(isset($data['variants']) && is_array($data['variants'])){
        //Al ser un producto nuevo las variantes no existen

            foreach ($data['variants'] as $variantData) {
                $variant=new Product($variantData);
                $variant->setIsVariant(true);
                $variant->setBaseProduct($product);
                $this->addAttributesToProduct($variant,$variantData);

                $this->em->persist($variant);
                $this->em->flush();
                
                $productVariant=new ProductVariant();
                $productVariant->setProduct($product);
                $productVariant->setVariant($variant);
                $this->em->persist($productVariant);
            }
        }
        
        $this->em->flush();
        return $product;
    }
    
    private function addAttributesToProduct(Product $product,array $data){
        if(isset($data['attributes']) && is_array($data['attributes'])){
            foreach ($data['attributes'] as $attributeName => $value) {
                $attributesRepo= $this->em->getRepository(Attribute::class);
                $attribute = $attributesRepo->findOneBy(['name'=>$attributeName]);
                
                if(!$attribute){
                    $attribute=new Attribute();
                    $attribute->setName($attributeName);
                    $this->em->persist($attribute);
                }
                
                $productAttribute=new ProductAttribute();
                $productAttribute->setProduct($product);
                $productAttribute->setAttribute($attribute);
                $productAttribute->setValue($value);
                $this->em->persist($productAttribute);
            }
        }
    }

    private function addCategoriesToProduct(Product $product, array $data)
    {
        if (isset($data['categories']) && is_array($data['categories'])) {
            foreach ($data['categories'] as $categoryId) {
                $categoryRepo = $this->em->getRepository(Category::class);
                $category = $categoryRepo->find($categoryId);

                if ($category) {
                    $productCategory = new ProductCategory();
                    $productCategory->setProduct($product);
                    $productCategory->setCategory($category);
                    $this->em->persist($productCategory);
                }
            }
        }
    }

    public function deleteProduct($productId)
    {
        $productRepo = $this->em->getRepository(Product::class);
        $product = $productRepo->find($productId);

        if (!$product) {
            throw new \Exception("Producto no encontrado.");
        }

        foreach ($product->getVariants() as $variant) {
            $this->em->remove($variant);
        }

        $this->em->remove($product);
        $this->em->flush();

    }

    public function updateProduct($id, $data)
    {
        $productRepo = $this->em->getRepository(Product::class);
        $product = $productRepo->find($id);

        if (!$product) {
            throw new \Exception('Producto no encontrado');
        }

        // Si el campo llega se edita
        $this->updateBasicFields($product, $data);
        if(isset($data['attributes'])){
            $this->updateAttributes($product, $data);
        }

        if(isset($data['variants'])){
            $this->updateVariants($product, $data);
        }

        if(isset($data['categories'])){
            $this->updateCategories($product, $data);
        }

        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }

    private function updateBasicFields(Product $product, array $data)
    {
        $fields = [
            'name', 'active', 'description', 'purchasePrice', 'margin', 'sellPrice', 'images'
        ];

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $setter = 'set' . ucfirst($field); //pone la primera letra en Mayuscula
                $product->$setter($data[$field]);
            }
        }
    }

    private function updateAttributes(Product $product, array $data)
    {
        // Eliminar atributos viejos de productAttributes
        foreach ($product->getProductAttributes() as $productAttribute) {
            $this->em->remove($productAttribute);
        }

        $this->em->flush();

        // Agregar nuevos atributos
        $this->addAttributesToProduct($product, $data);
    }

    private function updateVariants(Product $product, array $data)
    {
        $productVariantsRepo = $this->em->getRepository(ProductVariant::class);
        
        // Eliminar variantes antiguas (solo la relación, no los productos en sí)
        foreach ($product->getProductVariants() as $productVariant) {
            $this->em->remove($productVariant);
        }

        $this->em->flush();

        // Agregar nuevas variantes o actualizar las existentes
        if (isset($data['variants']) && is_array($data['variants'])) {
            foreach ($data['variants'] as $variantData) {
                $variantId = $variantData['id'] ?? null;
                $variant = $variantId ? $this->em->getRepository(Product::class)->find($variantId) : new Product($variantData);

                // if (!$variant) {
                //     $variant = new Product($variantData);
                // }

                $variant->setIsVariant(true);
                $variant->setBaseProduct($product);
                $this->addAttributesToProduct($variant, $variantData);
                $this->updateBasicFields($variant,$variantData);

                $this->em->persist($variant);
                $this->em->flush();

                $productVariant = new ProductVariant();
                $productVariant->setProduct($product);
                $productVariant->setVariant($variant);
                $this->em->persist($productVariant);
            }
        }
    }


    private function updateCategories(Product $product, array $data)
    {
        // Eliminar categorías antiguas
        foreach ($product->getProductCategories() as $productCategory) {
            $this->em->remove($productCategory);
        }

        $this->em->flush();

        // Agregar nuevas categorías
        $this->addCategoriesToProduct($product, $data);
    }

    public function getProduct($value)
    {
        $productRepo = $this->em->getRepository(Product::class);
        $product = null;

        if (is_numeric($value)) {
            $product = $productRepo->find($value);
        } else {
            $product = $productRepo->findOneBy(['name' => $value]);
        }

        if (!$product) {
            throw new \Exception('Producto no encontrado');
        }

        $context = SerializationContext::create()->setGroups(['product']);
        $productArray = $this->serializer->serialize($product, 'json', $context);
        return json_decode($productArray, true);
    }

    public function getAllProducts()
    {
        $productRepo = $this->em->getRepository(Product::class);
        $products = $productRepo->findAll();

        $context = SerializationContext::create()->setGroups(['product']);
        $productsArray = $this->serializer->serialize($products, 'json', $context);
        return json_decode($productsArray, true);
    }

    public function getAllProductsPublic()
    {
        $productRepo = $this->em->getRepository(Product::class);
        $products = $productRepo->findAll(['is_active'=>true]);

        $context = SerializationContext::create()->setGroups(['product']);
        $productsArray = $this->serializer->serialize($products, 'json', $context);
        return json_decode($productsArray, true);
    }
  
}
