<?php

namespace App\Exceptions\Transformers;

use Exception;
use App\Exceptions\TraceableFatalErrorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use GrahamCampbell\Exceptions\Transformers\TransformerInterface;

class FatalThrowableErrorTransformer implements TransformerInterface
{
    /**
     * Transform the provided exception.
     *
     * @param  \Exception  $exception
     *
     * @return \Exception
     */
    public function transform(Exception $exception)
    {
        // Make sure the exception is a fatal throwable error
        if(!$exception instanceof FatalThrowableError) {
            return $exception;
        }

        // Recast the exception
        return new TraceableFatalErrorException($exception);
    }
}
