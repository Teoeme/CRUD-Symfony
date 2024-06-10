<?php
// src/AppBundle/Entity/Product.php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;


/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Groups({"product"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product"})
     *
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     * @Groups({"product"})
     *
     */
    private $active;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"product"})
     
     */
    private $description;

   /**
     * @ORM\OneToMany(targetEntity="ProductCategory", mappedBy="product", cascade={"persist", "remove"})
     */
    private $productCategories;

    /**
     * @ORM\Column(type="decimal", scale=2, options={"default":0,00}, nullable=true)
     * @Groups({"product"})
     *
     */
    private $purchasePrice;

    /**
     * @ORM\Column(type="decimal", scale=2, options={"default":0,00})
     * @Groups({"product"})
     *
     */
    private $margin;

    /**
     * @ORM\Column(type="decimal", scale=2, options={"default":0,00}, nullable=true)
     * @Groups({"product"})
     *
     */
    private $sellPrice;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     * @Groups({"product"})
     *
     */
    private $images;

/**
     * @ORM\OneToMany(targetEntity="ProductAttribute", mappedBy="product", cascade={"persist", "remove"})
     */
    private $productAttributes;


    /**
     * @ORM\OneToMany(targetEntity="ProductVariant", mappedBy="product", cascade={"persist", "remove"})
     *
     */
    private $productVariants;

     /**
     * @ORM\Column(type="boolean", options={"default": false})
     * @Groups({"product"})
     */
    private $isVariant;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="variants")
     * @ORM\JoinColumn(name="base_product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $baseProduct;

       /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="baseProduct", cascade={"persist", "remove"})
     * @Groups({"product"})
     *
     */
    private $variants;
    
  

    public function __construct(array $data = [])
    {
        $this->productCategories = new ArrayCollection();
        $this->margin = 0.00;
        $this->purchasePrice = 0.00;
        $this->sellPrice = 0.00;
        $this->active = true;
        $this->isVariant = false;
        $this->productAttributes = new ArrayCollection();
        $this->productVariants = new ArrayCollection();
        $this->variants = new ArrayCollection();
        $this->images = new ArrayCollection();
        
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                if ($key !== 'variants') {
                    $this->{$key} = $value;
                }
            }
        }
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Product
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set purchasePrice
     *
     * @param string $purchasePrice
     *
     * @return Product
     */
    public function setPurchasePrice($purchasePrice)
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    /**
     * Get purchasePrice
     *
     * @return string
     */
    public function getPurchasePrice()
    {
        return $this->purchasePrice;
    }

    /**
     * Set margin
     *
     * @param string $margin
     *
     * @return Product
     */
    public function setMargin($margin)
    {
        $this->margin = $margin;

        return $this;
    }

    /**
     * Get margin
     *
     * @return string
     */
    public function getMargin()
    {
        return $this->margin;
    }

    /**
     * Set sellPrice
     *
     * @param string $sellPrice
     *
     * @return Product
     */
    public function setSellPrice($sellPrice)
    {
        $this->sellPrice = $sellPrice;

        return $this;
    }

    /**
     * Get sellPrice
     *
     * @return string
     */
    public function getSellPrice()
    {
        return $this->sellPrice;
    }

    /**
     * Set images
     *
     * @param array $images
     *
     * @return Product
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add productAttribute
     *
     * @param \AppBundle\Entity\ProductAttribute $productAttribute
     *
     * @return Product
     */
    public function addProductAttribute(\AppBundle\Entity\ProductAttribute $productAttribute)
    {
        $this->productAttributes[] = $productAttribute;

        return $this;
    }

    /**
     * Remove productAttribute
     *
     * @param \AppBundle\Entity\ProductAttribute $productAttribute
     */
    public function removeProductAttribute(\AppBundle\Entity\ProductAttribute $productAttribute)
    {
        $this->productAttributes->removeElement($productAttribute);
    }

    /**
     * Get productAttributes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductAttributes()
    {
        return $this->productAttributes;
    }

    /**
     * Add productVariant
     *
     * @param \AppBundle\Entity\ProductVariant $productVariant
     *
     * @return Product
     */
    public function addProductVariant(\AppBundle\Entity\ProductVariant $productVariant)
    {
        $this->productVariants[] = $productVariant;

        return $this;
    }

    /**
     * Remove productVariant
     *
     * @param \AppBundle\Entity\ProductVariant $productVariant
     */
    public function removeProductVariant(\AppBundle\Entity\ProductVariant $productVariant)
    {
        $this->productVariants->removeElement($productVariant);
    }

    /**
     * Get productVariants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductVariants()
    {
        return $this->productVariants;
    }

    /**
     * Set isVariant
     *
     * @param boolean $isVariant
     *
     * @return Product
     */
    public function setIsVariant($isVariant)
    {
        $this->isVariant = $isVariant;

        return $this;
    }

    /**
     * Get isVariant
     *
     * @return boolean
     */
    public function getIsVariant()
    {
        return $this->isVariant;
    }

    /**
     * Set baseProduct
     *
     * @param \AppBundle\Entity\Product $baseProduct
     *
     * @return Product
     */
    public function setBaseProduct(\AppBundle\Entity\Product $baseProduct = null)
    {
        $this->baseProduct = $baseProduct;

        return $this;
    }

    /**
     * Get baseProduct
     *
     * @return \AppBundle\Entity\Product
     */
    public function getBaseProduct()
    {
        return $this->baseProduct;
    }

    /**
     * Add variant
     *
     * @param \AppBundle\Entity\Product $variant
     *
     * @return Product
     */
    public function addVariant(\AppBundle\Entity\Product $variant)
    {
        $this->variants[] = $variant;

        return $this;
    }

    /**
     * Remove variant
     *
     * @param \AppBundle\Entity\Product $variant
     */
    public function removeVariant(\AppBundle\Entity\Product $variant)
    {
        $this->variants->removeElement($variant);
    }

    /**
     * Get variants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVariants()
    {
        return $this->variants;
    }
    

    /**
     * Add productCategory
     *
     * @param \AppBundle\Entity\ProductCategory $productCategory
     *
     * @return Product
     */
    public function addProductCategory(\AppBundle\Entity\ProductCategory $productCategory)
    {
        $this->productCategories[] = $productCategory;

        return $this;
    }

    /**
     * Remove productCategory
     *
     * @param \AppBundle\Entity\ProductCategory $productCategory
     */
    public function removeProductCategory(\AppBundle\Entity\ProductCategory $productCategory)
    {
        $this->productCategories->removeElement($productCategory);
    }

    /**
     * Get productCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductCategories()
    {
        return $this->productCategories;
    }

     /**
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("attributes")
     * @JMS\Groups({"product"})
     */
    public function getSerializedAttributes()
    {
        $attributes = [];

        foreach ($this->productAttributes as $productAttribute) {
            $attributes[] = [
                'id' => $productAttribute->getAttribute()->getId(),
                'name' => $productAttribute->getAttribute()->getName(),
                'value' => $productAttribute->getValue()
            ];
        }

        return $attributes;
    }


/**
 * @JMS\VirtualProperty()
 * @JMS\SerializedName("categories")
 * @JMS\Groups({"product"})
 */
public function getCategoryIds()
{
    return $this->productCategories->map(function($productCategory) {
        return $productCategory->getCategory()->getId();
    })->toArray();
}

}
