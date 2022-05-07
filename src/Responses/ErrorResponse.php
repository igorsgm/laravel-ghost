<?php

namespace Igorsgm\Ghost\Responses;


use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

class ErrorResponse
{
    /**
     * @var Response
     */
    private Response $response;

    /**
     * @var bool
     */
    public $success = false;

    /**
     * @var Collection|array
     */
    public $errors = [];

    /**
     * @param  Response  $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
        $this->handle();
    }

    /**
     * @return boolean
     */
    private function handle()
    {
        $this->errors = collect();

        if (!config('ghost.debug_enabled')) {
            $this->errors->push((object) [
                'message' => 'Something went wrong. Please try again later.',
            ]);

            return false;
        }

        $responseErrors = $this->response->json('errors') ?? [];

        foreach ($responseErrors as $error) {
            $this->errors->push((object) $error);
        }

        return true;
    }
}
