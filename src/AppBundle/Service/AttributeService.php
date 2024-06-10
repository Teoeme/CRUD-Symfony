<?php
namespace AppBundle\Service;

use AppBundle\Entity\Attribute;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;

class AttributeService
{
    private $em;
    private $serializer;

    public function __construct(EntityManagerInterface $em,Serializer $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }




    public function getAllAttributes()
    {
        $attributesRepo=$this->em->getRepository(Attribute::class);
        $attiributes= $attributesRepo->findAll();

        $context = SerializationContext::create()->setGroups(['attributes']);
        $attributesArray = $this->serializer->serialize($attiributes, 'json', $context);
        return json_decode($attributesArray, true);

    }
}
