<?php


namespace src\Model;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Proxy;

/**
 * Class Product
 * @package src\Model
 * @ORM\Entity(repositoryClass="src\Repository\ProductRepository")
 * @ORM\Table("sa_product_category")
 */
class ProductCategory
{
    /**
     * @var Product|null
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="categories")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $product;

    /**
     * @var Category|null
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $category;

    /**
     * @return Product|Proxy|null
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product|Proxy|null $product
     *
     * @return ProductCategory
     */
    public function setProduct($product): ProductCategory
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Category|Proxy|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category|Proxy|null $category
     *
     * @return ProductCategory
     */
    public function setCategory($category): ProductCategory
    {
        $this->category = $category;

        return $this;
    }
}