<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPropertyValue;
use App\Models\Property;
use App\Models\PropertyValue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): LengthAwarePaginator
    {
        $values = [];
        $properties = key_exists('properties', $request->all()) ? $request->all()['properties'] : [];
        foreach ($properties as $name => $propertyValues) {
            $findProperty = Property::query()->where('name', $name)->first();

            if (!$findProperty) {
                continue;
            }

            foreach ($propertyValues as $value) {
                $findValue = PropertyValue::query()
                    ->where('property_id', $findProperty['id'])
                    ->where('value', $value)
                    ->first();

                if ($findValue) {
                    $values[] = $findValue['id'];
                }
            }
        }

        $products = ProductPropertyValue::query()->whereIn('property_value_id', $values)->get();
        $result = [];
        foreach ($products as $item) {
            /** @var Product $item */
            $product = $item->product;
            $valuesPivot = $product->propertyValues()->select('id')->pluck('id')->toArray();
            $intersect = array_intersect($valuesPivot, $values);
            if (array_values($intersect) == array_values($values) && !in_array($item->product->id, $result)) {
                $result[] = $item->product->id;
            }
        }

        return ProductPropertyValue::query()->whereIn('product_id', $result)->distinct('product_id')->paginate();
    }
}
