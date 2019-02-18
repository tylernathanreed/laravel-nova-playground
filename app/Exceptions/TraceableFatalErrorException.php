<?php

namespace App\Exceptions;

use Exception;
use ReflectionProperty;
use Symfony\Component\Debug\Exception\FatalErrorException;

class TraceableFatalErrorException extends Exception
{
	/**
	 * Creates a new traceable fatal error exception.
	 *
	 * @param  \Symfony\Component\Debug\Exception\FatalErrorException  $exception
	 *
	 * @return $this
	 */
	public function __construct(FatalErrorException $exception)
	{
		parent::__construct($exception->getMessage(), $exception->getCode());

		$this->setTrace($exception->getTrace());
	}

	/**
	 * Sets the exception stack trace.
	 *
	 * @param  array  $trace
	 *
	 * @return void
	 */
    protected function setTrace($trace)
    {
        $property = new ReflectionProperty('Exception', 'trace');
        $property->setAccessible(true);
        $property->setValue($this, $trace);
    }
}