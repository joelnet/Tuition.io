<?php

namespace App\Validators;

/**
 * Validates an address against the Google Map API.
 */
class AddressValidator
{
    public static function validate($validator, $address)
    {
        $validator->after(function() use ($validator, $address)
        {
            $key = env('GOOGLE_MAP_API_KEY');
            $encodedAddress = urlencode("$address->address1, $address->address2, $address->city, $address->state $address->postal_code");
            $json = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$encodedAddress&key=$key"));

            if ($json->status != 'OK')
            {
                $validator->errors()->add('address', 'The address is not a valid USPS address.');
            }
        });

        return $validator;
    }
}
