<?php
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

if (!function_exists('is_customer')) {
    function is_customer()
    {
        return \Auth::guard('customer')->check();
    }
}


if (!function_exists('user')) {
    function user()
    {
        $user = null;
        if(is_customer()) {
            $user =  \Auth::guard('customer')->user();
        }
        return $user;
    }
}

if (!function_exists('message_set')) {
    function message_set($message = "", $type = "success")
    {
        session()->flash('message.level', $type);
        session()->flash('message.content', $message);
    }
}

if (!function_exists('image')) {
    function image($fileName,$size = ''): ?string
    {
        if(empty($fileName)) return null;
        $fileNameArr = explode('.',$fileName);

        $newFileName = '';
        for ($i = 0; $i < count($fileNameArr); $i++){
            if ($i == (count($fileNameArr)-1)){
                $newFileName .= $size.'.'.$fileNameArr[$i];
            }else{
                $newFileName .= $fileNameArr[$i];
            }
        }
        return Storage::disk('public')->url($newFileName);
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($path = "", $name = "file", $resizeOptions = null)
    {
        $file     = request()->file($name);
        $fileName = $name.'.'.$file->getClientOriginalExtension();
        if($resizeOptions) {
            $width = $resizeOptions['width'] ?? null;
            $height = $resizeOptions['height'] ?? null;
            Image::make($file)->resize($width, $height, function($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path("app/public{$path}/{$fileName}"));
            return ltrim("{$path}/{$fileName}", '/');
        } else {
            return Storage::disk(config('voyager.storage.disk'))->putFileAs($path,request()->file($name),$fileName);
        }
    }
}

if (!function_exists('format_price')) {
    function format_price($price): string
    {
        if(is_numeric($price) && floor($price) != $price){
            return number_format((float)$price, 2, '.', '');
        }else{
            return floatval($price);
        }
//        return number_format((float)$price, 2, '.', '');
    }
}

if (!function_exists('is_decimal')) {
    function is_decimal($val)
    {
        return is_numeric($val) && floor($val) != $val;
    }
}

if (!function_exists('generateToken')) {
    function generateToken()
    {
        $header = (object)[
            'alg' => "HS256",
            'typ' => 'JWT'
        ];
        $payLoad = (object)[
            'iss' => env('PWN_API_KEY'),
            'iat' => strtotime(now()),
            'exp' => strtotime(now()) + 5000,
            'ver' => 1
        ];
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($header)));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payLoad)));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, env('PWN_API_TOKEN'), true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        return $jwt;
    }
}

if (!function_exists('pscActivities')) {
    function pscActivities()
    {
        return [
          ['value' => '1', 'display' => 'Routine'],
          ['value' => '2', 'display' => 'Drug screen'],
          ['value' => '3', 'display' => 'Pediatric draw'],
          ['value' => '4', 'display' => 'Glucose tolerance'],
          ['value' => '8', 'display' => 'Semen Analysis'],
          ['value' => '5', 'display' => 'Lab card'],
          ['value' => '20', 'display' =>  'BFW'],
          ['value' => '21', 'display' =>  'BFW with biometrics'],
          ['value' => '22', 'display' =>  'QUANTIFERON-TB GOLD (Tspot)'],
          ['value' => '23', 'display' =>  'All of Us (Client specific)'],
          ['value' => '25', 'display' =>  'COVID Antibody Test'],
          ['value' => '26', 'display' =>  'COVID Antibody Test'],
          ['value' => '27', 'display' =>  'COVID Walmart'],
        ];
    }
}

if (!function_exists('HmacSHA1Encrypt')) {
    function HmacSHA1Encrypt(String $encryptText,String $encryptKey ){
        $hash_hmac = hash_hmac("sha1",$encryptText,$encryptKey,true);
        $signature = base64_encode($hash_hmac);
        return $signature;
    }
}

if (!function_exists('getProductById')) {
    function getProductById($id){
        return \App\Models\Product::find($id);
    }
}
