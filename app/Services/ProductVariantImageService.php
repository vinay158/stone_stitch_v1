<?php

namespace App\Services;

use App\Models\ProductVariantImage;
use App\Utility\ProductUtility;
use Combinations;

class ProductVariantImageService
{
    public function store(array $data, $product)
    {

        $collection = collect($data);
        if (isset($collection['variant_images']) && !empty($collection['variant_images'])) {
            ProductVariantImage::where('product_id', $collection['product_id'])->delete();
            foreach ($collection['variant_images'] as $key => $val) {                
                $related_product = new ProductVariantImage();
                $related_product->image = $val[0];
                $related_product->product_id = $collection['product_id'];
                $related_product->variant = $key;
                $related_product->save();
                //RelatedProduct::create($related_product);
            }
        }
        
        
    }

}
