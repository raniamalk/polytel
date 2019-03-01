<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 28/02/2019
 * Time: 13:18
 */

namespace AppBundle\Entity;


use Sylius\Component\Product\Model\Product as BaseProduct;
use Doctrine\ORM\Mapping as ORM;



class Product extends BaseProduct
{

    /**
     * @var product
     *
     *
     *
     * @ORM\ManyToOne( targetEntity="marque", inversedBy="product", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     *
     *
     */
    protected $marque;

    /**
     * @return Product
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @param Product $marque
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
    }



}