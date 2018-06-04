<?php

namespace Backoffice\Requests;

use App\Exceptions\BadRequestException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
abstract class AbstractFormRequest extends FormRequest
{
    /**
     * Response handler.
     *
     * @param array $errors
     * @return json
     */
    public function response(array $errors)
    {
        return response()->json($errors, 422);
    }
    /**
     * @apiDefine FailedValidation
     * @apiGroup general
     * @apiError (4xx Client Errors) invalid_post_data Invalid post data
     * @apiErrorExample 400 Bad Request Example:
     * HTTP/1.1 400 Bad Request
     * {
     *     "error": {
     *        "code":"invalid_post_data",
     *        "message":"Invalid post data.",
     *        "details": {"name":["The name field is required."]}
     *
     *     }
     * }
     */
    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestException('invalid_post_data', 'Invalid post data', (array)$validator->errors()->getMessages());
    }

    public function authorize()
    {
        return true;
    }

    protected function failedAuthorization() {
        return response()->json('unauthorized');
    }
}
