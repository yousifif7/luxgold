
<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

if (! function_exists('handleResponse')) {
    function handleResponse($request, string $message, string $redirectRoute, $statusCode = 200, array $extra = []): JsonResponse|RedirectResponse
    {
        if ($request->ajax()) {
            return response()->json(array_merge([
                'status' => $statusCode,
                'message' => $message,
                'redirect_url' => route($redirectRoute),
            ], $extra))->setEncodingOptions(JSON_NUMERIC_CHECK)->setStatusCode($statusCode);
        }

        if ($statusCode !== 200) {
            // Send errors via session for redirect
            return redirect($redirectRoute)->with('error', $message)->withErrors($extra['errors'] ?? []);
        }

        return redirect($redirectRoute)->with('success', $message);
    }
}  

if (! function_exists('handleAjaxResponse')) {
    function handleAjaxResponse($request, string $message, string $redirectRoute, $statusCode = 200, array $extra = []): JsonResponse|RedirectResponse
    {
            return response()->json(array_merge([
                'status' => $statusCode,
                'message' => $message,
                'redirect_url' => route($redirectRoute),
            ], $extra))->setEncodingOptions(JSON_NUMERIC_CHECK)->setStatusCode($statusCode);
        

        
    }
}  


if (! function_exists('generateSlug')) {

    function generateSlug($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }
}
?>