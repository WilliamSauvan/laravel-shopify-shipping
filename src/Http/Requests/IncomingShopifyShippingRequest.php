<?php

namespace ShopifyShipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Log;

class IncomingShopifyShippingRequest extends FormRequest
{
    public const string RATE = 'rate';

    public const string ORIGIN = 'origin';

    public const string DESTINATION = 'destination';

    public const string ITEMS = 'items';

    public const string CURRENCY = 'currency';

    public const string LOCALE = 'locale';

    public const string ORIGIN_COUNTRY = 'country';

    public const string ORIGIN_POSTAL_CODE = 'postal_code';

    public const string ORIGIN_PROVINCE = 'province';

    public const string ORIGIN_CITY = 'city';

    public const string ORIGIN_NAME = 'name';

    public const string ORIGIN_ADDRESS1 = 'address1';

    public const string ORIGIN_ADDRESS2 = 'address2';

    public const string ORIGIN_ADDRESS3 = 'address3';

    public const string ORIGIN_LATITUDE = 'latitude';

    public const string ORIGIN_LONGITUDE = 'longitude';

    public const string ORIGIN_PHONE = 'phone';

    public const string ORIGIN_FAX = 'fax';

    public const string ORIGIN_EMAIL = 'email';

    public const string ORIGIN_ADDRESS_TYPE = 'address_type';

    public const string ORIGIN_COMPANY_NAME = 'company_name';

    public const string DESTINATION_COUNTRY = 'country';

    public const string DESTINATION_POSTAL_CODE = 'postal_code';

    public const string DESTINATION_PROVINCE = 'province';

    public const string DESTINATION_CITY = 'city';

    public const string DESTINATION_NAME = 'name';

    public const string DESTINATION_ADDRESS1 = 'address1';

    public const string DESTINATION_ADDRESS2 = 'address2';

    public const string DESTINATION_ADDRESS3 = 'address3';

    public const string DESTINATION_LATITUDE = 'latitude';

    public const string DESTINATION_LONGITUDE = 'longitude';

    public const string DESTINATION_PHONE = 'phone';

    public const string DESTINATION_FAX = 'fax';

    public const string DESTINATION_EMAIL = 'email';

    public const string DESTINATION_ADDRESS_TYPE = 'address_type';

    public const string DESTINATION_COMPANY_NAME = 'company_name';

    public const string ITEM_NAME = 'name';

    public const string ITEM_SKU = 'sku';

    public const string ITEM_QUANTITY = 'quantity';

    public const string ITEM_GRAMS = 'grams';

    public const string ITEM_PRICE = 'price';

    public const string ITEM_VENDOR = 'vendor';

    public const string ITEM_REQUIRES_SHIPPING = 'requires_shipping';

    public const string ITEM_TAXABLE = 'taxable';

    public const string ITEM_FULFILLMENT_SERVICE = 'fulfillment_service';

    public const string ITEM_PROPERTIES = 'properties';

    public const string ITEM_PRODUCT_ID = 'product_id';

    public const string ITEM_VARIANT_ID = 'variant_id';

    public function rules(): array
    {
        return [
            self::RATE                        => ['required', 'array'],
            self::RATE . '.' . self::CURRENCY => ['required', 'string', 'size:3'],
            self::RATE . '.' . self::LOCALE   => ['required', 'string'],

            self::RATE . '.' . self::ORIGIN                                   => ['required', 'array'],
            self::RATE . '.' . self::ORIGIN . '.' . self::ORIGIN_COUNTRY      => ['nullable', 'string', 'size:2'],
            self::RATE . '.' . self::ORIGIN . '.' . self::ORIGIN_POSTAL_CODE  => ['nullable', 'string'],
            self::RATE . '.' . self::ORIGIN . '.' . self::ORIGIN_CITY         => ['nullable', 'string'],
            self::RATE . '.' . self::ORIGIN . '.' . self::ORIGIN_ADDRESS1     => ['nullable', 'string'],
            self::RATE . '.' . self::ORIGIN . '.' . self::ORIGIN_LATITUDE     => ['nullable', 'numeric'],
            self::RATE . '.' . self::ORIGIN . '.' . self::ORIGIN_LONGITUDE    => ['nullable', 'numeric'],
            self::RATE . '.' . self::ORIGIN . '.' . self::ORIGIN_COMPANY_NAME => ['nullable', 'string'],

            self::RATE . '.' . self::DESTINATION                                        => ['required', 'array'],
            self::RATE . '.' . self::DESTINATION . '.' . self::DESTINATION_COUNTRY      => ['nullable', 'string', 'size:2'],
            self::RATE . '.' . self::DESTINATION . '.' . self::DESTINATION_POSTAL_CODE  => ['nullable', 'string'],
            self::RATE . '.' . self::DESTINATION . '.' . self::DESTINATION_CITY         => ['nullable', 'string'],
            self::RATE . '.' . self::DESTINATION . '.' . self::DESTINATION_ADDRESS1     => ['nullable', 'string'],
            self::RATE . '.' . self::DESTINATION . '.' . self::DESTINATION_LATITUDE     => ['nullable', 'numeric'],
            self::RATE . '.' . self::DESTINATION . '.' . self::DESTINATION_LONGITUDE    => ['nullable', 'numeric'],
            self::RATE . '.' . self::DESTINATION . '.' . self::DESTINATION_COMPANY_NAME => ['nullable', 'string'],

            self::RATE . '.' . self::ITEMS                                          => ['required', 'array'],
            self::RATE . '.' . self::ITEMS . '.*.' . self::ITEM_NAME                => ['nullable', 'string'],
            self::RATE . '.' . self::ITEMS . '.*.' . self::ITEM_SKU                 => ['nullable', 'string'],
            self::RATE . '.' . self::ITEMS . '.*.' . self::ITEM_QUANTITY            => ['required', 'integer', 'min:1'],
            self::RATE . '.' . self::ITEMS . '.*.' . self::ITEM_GRAMS               => ['required', 'integer', 'min:0'],
            self::RATE . '.' . self::ITEMS . '.*.' . self::ITEM_PRICE               => ['required', 'integer', 'min:0'],
            self::RATE . '.' . self::ITEMS . '.*.' . self::ITEM_VENDOR              => ['nullable', 'string'],
            self::RATE . '.' . self::ITEMS . '.*.' . self::ITEM_REQUIRES_SHIPPING   => ['required', 'boolean'],
            self::RATE . '.' . self::ITEMS . '.*.' . self::ITEM_TAXABLE             => ['required', 'boolean'],
            self::RATE . '.' . self::ITEMS . '.*.' . self::ITEM_FULFILLMENT_SERVICE => ['required', 'string'],
            self::RATE . '.' . self::ITEMS . '.*.' . self::ITEM_PROPERTIES          => ['nullable'],
            self::RATE . '.' . self::ITEMS . '.*.' . self::ITEM_PRODUCT_ID          => ['nullable', 'integer'],
            self::RATE . '.' . self::ITEMS . '.*.' . self::ITEM_VARIANT_ID          => ['nullable', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('IncomingShopifyShippingRequest validation failed', [
            'errors' => $validator->errors(),
        ]);

        throw new HttpResponseException(response()->json([
            'message' => 'Failed validation',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
