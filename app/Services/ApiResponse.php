<?php

namespace App\Services;

use Illuminate\Http\Response;

class ApiResponse
{
    public mixed $code;
    public mixed $msg;
    public mixed $details;
    public array $errors = [];
    public mixed $status;
    public mixed $http_status;
    public array $headers = [];
    public mixed $data;
    public static string $SUCCESS = 'success';
    public static string $ERROR = 'error';
    public static string $NOT_FOUND = 'not_found';
    public static string $NEED_PARAMS = 'need_params';
    public static string $EDITED = 'edited';
    public static string $CREATED = 'created';
    public static string $DELETED = 'deleted';
    public static string $UNAUTHORIZED = 'unauthorized';
    public static string $PERMISSION_DENIED = 'permission_denied';
    public static string $BAD_REQUEST = 'bad_request';
    private array $tpls = [
        'success' => ['code' => 'success', 'msg' => 'Successful request', 'status' => 200, 'http_status' => 200],
        'error' => ['code' => 'error', 'msg' => 'Something happened when try to process your request', 'status' => 200, 'http_status' => 500],
        'not_found' => ['code' => 'error', 'msg' => 'Can\'t found this item, please try again', 'status' => 200, 'http_status' => 404],
        'need_params' => ['code' => 'error', 'msg' => 'Some required values are not received', 'status' => 200, 'http_status' => 400],
        'edited' => ['code' => 'success', 'msg' => 'Change saved correctly', 'status' => 200, 'http_status' => 200],
        'created' => ['code' => 'success', 'msg' => 'Entry created', 'status' => 200, 'http_status' => 201],
        'deleted' => ['code' => 'success', 'msg' => 'Deleted', 'status' => 200, 'http_status' => 200],
        'bad_request' => ['code' => 'bad_request', 'msg' => 'Some data is not present to perform this action', 'status' => 200, 'http_status' => 400],
        'permission_denied' => [
            'code' => 'permission_denied',
            'msg' => 'You are not authorized to perform this action',
            'status' => 200,
            'http_status' => 403
        ],
        'unauthorized' => ['code' => 'unauthorized', 'msg' => 'You are not authorized to perform this action', 'status' => 403, 'http_status' => 401]
    ];

    public function __construct($data = null, $msg = null, $code = null, $status = null, $details = null)
    {
        $this->details = $details;
        $this->msg = $msg ?: $this->tpls['success']['msg'];
        $this->code = $code ?: $this->tpls['success']['code'];
        $this->status = $status ?: $this->tpls['success']['status'];
        $this->http_status = $status ?: $this->tpls['success']['status'];
        $this->data = $data;
    }

    /**
     * @return array[]
     */
    public function getStatusData(): array
    {
        return [
            'status' => [
                'code' => $this->code,
                'msg' => $this->msg,
                'details' => $this->details,
                'errors' => $this->errors
            ]
        ];
    }

    /**
     * @return array
     */
    public function getResponseData(): array
    {
        return [
            'data' => $this->data,
            'status' => [
                'http_status' => $this->http_status,
                'code' => $this->code,
                'msg' => $this->msg,
                'details' => $this->details,
                'errors' => $this->errors
            ]
        ];
    }

    /**
     * @param string $template
     * @param $msg
     * @param $details
     * @param $errors
     * @return $this
     */
    public function loadTemplate(string $template, $msg = null, $details = null, $errors = null): static
    {
        $this->details = $details;
        if ($errors) {
            $this->errors = $errors;
        }
        if (isset($this->tpls[$template])) {
            $this->msg = __($msg ?: $this->tpls[$template]['msg']);
            $this->code = $this->tpls[$template]['code'];
            $this->status = $this->tpls[$template]['status'];
            $this->http_status = $this->tpls[$template]['http_status'];
        }
        return $this;
    }

    /**
     * @param $template
     * @param $msg
     * @param $details
     * @param $data
     * @return Response
     */
    public function httpResponse($template = null, $msg = null, $details = null, $data = null): Response
    {
        if ($template) {
            $this->loadTemplate($template, $msg, $details);
        }
        if ($data) {
            $this->data = $data;
        }

        return response($this->getResponseData(), $this->http_status, $this->headers);
    }

    /**
     * @param $data
     * @param $msg
     * @param $code
     * @param $status
     * @param $details
     * @return ApiResponse
     */
    static function make($data = null, $msg = null, $code = null, $status = null, $details = null): ApiResponse
    {
        return new ApiResponse($data, $msg, $code, $status, $details);
    }

    /**
     * @param $errorMsg
     * @return void
     */
    public function registerError($errorMsg): void
    {
        $this->errors[] = $errorMsg;
    }
}
