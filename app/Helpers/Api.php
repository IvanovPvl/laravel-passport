<?php

namespace Helpers;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

trait Api
{
    /**
     * Return no content response
     *
     * @return Response
     */
    public function noContent()
    {
        return (new Response())->setStatusCode(BaseResponse::HTTP_NO_CONTENT);
    }

    /**
     * Respond with a created response and associate a location if provided.
     *
     * @param null $location
     * @param null $content
     * @return Response
     */
    public function created($location = null, $content = null)
    {
        $response = new Response($content);
        $response->setStatusCode(BaseResponse::HTTP_CREATED);
        if ($location) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * Return an error response.
     *
     * @param $message
     * @param $statusCode
     * @return mixed
     */
    public function error($message, $statusCode)
    {
        return response()->json(['error' => $message], $statusCode);
    }

    /**
     * Return a 404 not found error.
     *
     * @param string $message
     * @return mixed
     */
    public function errorNotFound($message = 'Not Found.')
    {
        return $this->error($message, BaseResponse::HTTP_NOT_FOUND);
    }

    /**
     * Return a 400 bad request error.
     *
     * @param string $message
     * @return mixed
     */
    public function errorBadRequest($message = 'Bad Request.')
    {
        return $this->error($message, BaseResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Return a 403 forbidden error.
     *
     * @param string $message
     * @return mixed
     */
    public function errorForbidden($message = 'Forbidden.')
    {
        return $this->error($message, BaseResponse::HTTP_FORBIDDEN);
    }

    /**
     * Return a 500 internal server error.
     *
     * @param string $message
     * @return mixed
     */
    public function errorInternal($message = 'Internal Error.')
    {
        return $this->error($message, BaseResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Return a 401 unauthorized error.
     *
     * @param string $message
     * @return mixed
     */
    public function errorUnauthorized($message = 'Unauthorized.')
    {
        return $this->error($message, BaseResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * Return a 405 method not allowed.
     *
     * @param string $message
     * @return mixed
     */
    public function errorMethodNotAllowed($message = 'Method Not Allowed.')
    {
        return $this->error($message, BaseResponse::HTTP_METHOD_NOT_ALLOWED);
    }
}