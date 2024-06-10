<?php

namespace AppBundle\Service;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Psr\Log\LoggerInterface;

class CategoryService
{
    private $em;
    private $logger;
    private $serializer;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger,Serializer $serializer)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    public function addCategory($data)
    {
        $categoriesRepo = $this->em->getRepository(Category::class);
        if (isset($data['parent_id'])) {
            $parent = $categoriesRepo->find($data['parent_id']);
            if (!$parent) {
                throw new \Exception("No existe la categoría padre");
            }

            // Revisar que no exista la categoria en este nivel
            $existingCategory = $categoriesRepo->findOneBy([
                'name' => $data['name'],
                'parent' => $parent
            ]);

            if ($existingCategory) {
                throw new \Exception("Ya existe la categoría");
            }
        } else {
            // Primer nivel
            $existingCategory = $categoriesRepo->findOneBy([
                'name' => $data['name'],
                'parent' => null
            ]);

            if ($existingCategory) {
                throw new \Exception("Ya existe la categoría");
            }
        }

        $category = new Category();
        $category->setName($data['name']);

        if (isset($data['parent_id'])) {
            $category->setParent($parent);
        }

        $this->em->persist($category);
        $this->em->flush();


        if (isset($data['children']) && is_array($data['children'])) {
            foreach ($data['children'] as $childData) {
                $childData['parent_id'] = $category->getId();
                $this->addCategory($childData);
            }
        }

        return $category;
    }

    public function getAllCategories()
    {
        $categoriesRepo = $this->em->getRepository(Category::class);
        $categories = $categoriesRepo->findAll();

        $context = SerializationContext::create()->setGroups(['categories']);
        $categoriesArray = $this->serializer->serialize($categories, 'json', $context);
        return json_decode($categoriesArray, true);
    }

    public function updateCategory($data, Category $parent = null)
    {
        $categoriesRepo = $this->em->getRepository(Category::class);

        if (isset($data['id'])) {
            $category = $categoriesRepo->find($data['id']);
            if (!$category) {
                throw new \Exception("Categoría no encontrada.");
            }
        } else {
            $this->logger->info('Creando nueva categoría');
            $category = new Category();
            $category->setName($data['name']);
            $parent->addChild($category);
            $this->em->persist($category);
        }

        if (isset($data['name'])) {
            $category->setName($data['name']);
        }

        if ($parent) {
            $category->setParent($parent);
        }

        // Manejar la lista de hijos
        $existingChildren = new ArrayCollection();
        foreach ($category->getChildren() as $child) {
            $existingChildren->add($child);
        }

        $this->logger->info('Hijos existentes: ' . count($existingChildren));

        if (isset($data['children']) && is_array($data['children'])) {
            foreach ($data['children'] as $childData) {
                if (isset($childData['id'])) {
                    $this->logger->info('Buscando hijo con ID: ' . $childData['id']);
                    $child = $categoriesRepo->find($childData['id']);
                    if (!$child) {
                        $this->logger->error('Hijo no encontrado para actualizar.');
                        throw new \Exception("Hijo no encontrado para actualizar.");
                    }
                    $existingChildren->removeElement($child);
                } else {
                    $this->logger->info('Creando nuevo hijo');
                }
                // Llamada recursiva pasando la categoría actual como padre:
                $this->updateCategory($childData, $category);
            }
        }

        // Eliminar los hijos que no están presentes en la actualización
        foreach ($existingChildren as $child) {
            $category->removeChild($child);
            $this->em->remove($child);
            // Eliminar los productos asociados al hijo eliminado
            foreach ($child->getProductCategories() as $productCategory) {
                $product = $productCategory->getProduct();
                $product->removeProductCategory($productCategory);
                $this->em->persist($product);
                $this->em->remove($productCategory);
            }
        }

        // Persistir la categoría actualizada
        $this->em->persist($category);
        $this->em->merge($category);
        $this->logger->info('Datos de categoria: ' . $category);

        $this->em->flush();
        $this->logger->info('Categoría actualizada: ' . $category);

        return $category;
    }

    public function deleteCategory($id)
    {
        $category = $this->em->getRepository(Category::class)->find($id);
        if (!$category) {
            throw new \Exception("Category not found");
        }

        $this->em->remove($category);
        $this->em->flush();
    }

    private function checkIfExist(array $data)
    {
        $categoriesRepo = $this->em->getRepository(Category::class);
        if (isset($data['parent_id'])) {
            $parent = $categoriesRepo->find($data['parent_id']);
            if (!$parent) {
                throw new \Exception("No existe la categoría padre");
            }

            // Revisar que no exista la categoria en este nivel
            $existingCategory = $categoriesRepo->findOneBy([
                'name' => $data['name'],
                'parent' => $parent
            ]);

            if ($existingCategory) {
                return true;
            }
        } else {
            // Primer nivel
            $existingCategory = $categoriesRepo->findOneBy([
                'name' => $data['name'],
                'parent' => null
            ]);

            if ($existingCategory) {
                return true;
            }
        }
        return false;
    }
}
