<?php

if (!function_exists('api_response')) {
    /**
     * Generate a standardized API response format.
     *
     * @param  bool  $success
     * @param  string|null  $message
     * @param  mixed  $data
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    function api_response($message = null, $status)
    {
        return response()->json([
            'message' => $message,
           // 'error' => $message = __('messages.welcome')
        ], $status);
    }
}
