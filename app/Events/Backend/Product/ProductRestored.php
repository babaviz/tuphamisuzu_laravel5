<?php

namespace App\Events\Backend\Product;

use Illuminate\Queue\SerializesModels;

/**
 * Class ProductRestored.
 */
class ProductRestored
{
    use SerializesModels;

    /**
     * @var
     */
    public $product;

    /**
     * @param $user
     */
    public function __construct($product)
    {
        $this->product = $product;
    }
}
