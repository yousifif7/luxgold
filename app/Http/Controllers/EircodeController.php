<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EircodeController extends Controller
{
    /**
     * Check whether provided Eircode is valid (basic format check) and return normalized Eircode.
     */
    public function check(Request $request)
    {
        $request->validate([
            'eircode' => ['required', 'string', 'max:20'],
        ]);

        $raw = strtoupper(trim($request->input('eircode')));
        // Normalize: allow with or without space, but return normalized with a space after 3 chars
        $normalized = preg_replace('/\s+/', '', $raw);
        if (strlen($normalized) === 7) {
            $normalized = substr($normalized, 0, 3) . ' ' . substr($normalized, 3);
        }

        // Basic pattern for Eircode: 3 characters + space + 4 characters (alphanumeric)
        $isValidFormat = (bool) preg_match('/^[A-Z0-9]{3}\s?[A-Z0-9]{4}$/', $raw);

        if (! $isValidFormat) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid Eircode format. Example: D02 X285 or D02X285.',
            ], 422);
        }

        // If a routing-keys file exists (storage/app/eircode_routing_keys.json), validate the
        // routing key (first 3 characters) against it to ensure the Eircode belongs to Ireland.
        $routingKey = strtoupper(substr(str_replace(' ', '', $normalized), 0, 3));
        $routingKeysFile = storage_path('app/eircode_routing_keys.json');
        $routingKeyValid = null; // null = unknown (no file), true/false = explicit

        if (file_exists($routingKeysFile)) {
            try {
                $content = json_decode(file_get_contents($routingKeysFile), true);
                if (is_array($content)) {
                    // Expect file to be an array of routing keys, e.g. ["D02","A65",...]
                    $keys = array_map('strtoupper', array_map('trim', $content));
                    $routingKeyValid = in_array($routingKey, $keys, true);
                }
            } catch (\Throwable $e) {
                // ignore parse errors and treat as unknown
                $routingKeyValid = null;
            }
        }

        if ($routingKeyValid === false) {
            return response()->json([
                'valid' => false,
                'message' => 'Eircode routing key not recognised as an Irish routing key.',
                'routing_key' => $routingKey,
            ], 422);
        }

        $response = [
            'valid' => true,
            'eircode' => $normalized,
            'message' => 'Eircode format looks valid.',
            'routing_key' => $routingKey,
        ];

        if ($routingKeyValid === null) {
            $response['note'] = 'Routing key verification not performed (no routing-keys file).';
        } else {
            $response['note'] = 'Routing key verified against local list.';
        }

        return response()->json($response);
    }
}
