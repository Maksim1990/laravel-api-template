<?php declare(strict_types=1);

namespace App\Exceptions\Formatter;

use App\Exceptions\Formatter\Model\Error;
use App\Exceptions\Formatter\Model\ErrorInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Response\ResponseTrait;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionFormatter
{
    use ResponseTrait;

    public function getResponse(Throwable $exception, ?string $overrideStatusCode = null): JsonResponse
    {
        return $this->getErrorResponse($this->processException($exception, $overrideStatusCode));
    }

    private function processException(Throwable $exception, ?string $overrideStatusCode): ErrorInterface
    {
        $errorMessage = $exception->getMessage();
        $errorCode = $overrideStatusCode ?? $exception->getCode();

        if (empty($errorCode)) {
            if ($exception instanceof NotFoundHttpException) {
                $errorCode = HttpResponse::HTTP_NOT_FOUND;
                $errorMessage = 'Route not found';
            } elseif ($exception instanceof ValidationException) {
                $errorCode = HttpResponse::HTTP_BAD_REQUEST;
            } elseif ($exception instanceof ModelNotFoundException) {
                $errorCode = HttpResponse::HTTP_NOT_FOUND;
                $errorMessage = sprintf(
                    'Model %s with ID %s not found',
                    $exception->getModel(),
                    $exception->getIds()[0] ?? 0
                );
            } else {
                $errorCode = HttpResponse::HTTP_INTERNAL_SERVER_ERROR;
            }
        }

        Log::channel('stderr')->error($errorMessage);

        return new Error((int)$errorCode, $errorMessage);
    }
}
