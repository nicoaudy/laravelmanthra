<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
     /**
      * @var int
      */
     protected $statusCode = Response::HTTP_OK;

     /**
      * @return int
      */
     protected function getStatusCode()
     {
          return $this->statusCode;
     }

     /**
      * @param $statusCode
      *
      * @return $this
      */
     protected function setStatusCode($statusCode)
     {
          $this->statusCode = $statusCode;
          return $this;
     }

     /**
      * @param string $message
      * @param array $headers
      *
      * @return mixed
      */
     protected function respondNotFound($message = 'Not Found', $headers = [])
     {
          return $this->setStatusCode(Response::HTTP_NOT_FOUND)->makeResponse(null, $message, $headers, 'error');
     }

     /**
      * @param string $message
      * @param array $headers
      *
      * @return mixed
      */
     protected function respondBadRequest($message = 'Bad Request', $headers = [])
     {
          return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->makeResponse(null, $message, $headers, 'error');
     }

     /**
      * @param string $message
      * @param array $headers
      *
      * @return mixed
      */
     protected function respondServerError($message = 'Server Error', $headers = [])
     {
          return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->makeResponse(null, $message, $headers, 'error');
     }

     /**
      * @param string $message
      * @param array $headers
      *
      * @return mixed
      */
     protected function respondConflict($message = 'Conflict', $headers = [])
     {
          return $this->setStatusCode(Response::HTTP_CONFLICT)->makeResponse(null, $message, $headers, 'error');
     }

     /**
      * @param string $message
      * @param array $headers
      *
      * @return mixed
      */
     protected function respondUnprocessable($message = 'Unprocessable Entity', $headers = [])
     {
          return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->makeResponse(null, $message, $headers, 'error');
     }

     /**
      * @param string $message
      * @param array $headers
      *
      * @return mixed
      */
     protected function respondUnauthorized($message = 'Unauthorized', $headers = [])
     {
          return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->makeResponse(null, $message, $headers, 'error');
     }

     /**
      * @param string $message
      * @param array $headers
      *
      * @return mixed
      */
     protected function respondForbidden($message = 'Forbidden', $headers = [])
     {
          return $this->setStatusCode(Response::HTTP_FORBIDDEN)->makeResponse(null, $message, $headers, 'error');
     }

     /**
      * @param $message
      * @param $data
      * @param array $headers
      *
      * @return mixed
      */
     protected function respondCreated($data = null, $message = 'data has been saved successfuly', $headers = [])
     {
          return $this->setStatusCode(Response::HTTP_CREATED)->makeResponse($data, $message, $headers);
     }

     /**
      * @param $data
      * @param $message
      * @param array $headers
      *
      * @return mixed
      */
     protected function makeResponse($data = null, $message = null, $headers = [], $result = 'success')
     {
          $result = [
               'status' => $result,
               'status_code' => $this->statusCode,
          ];
          if (!empty($message)) $result['message'] = $message;
          if (!empty($data)) $result['data'] = $data;

          return $this->respond($result, $headers);
     }

     /**
      * @param $data
      * @param array $headers
      *
      * @return mixed
      */
     protected function respond($data, $headers = [])
     {
          return response()->json($data, $this->getStatusCode(), $headers);
     }

     /**
      * @param $message
      *
      * @return mixed
      */
     protected function respondWithError($message)
     {
          return $this->respond([
               'error' => [
                    'data'        => $message,
                    'status_code' => $this->getStatusCode()
               ]
          ]);
     }
}
