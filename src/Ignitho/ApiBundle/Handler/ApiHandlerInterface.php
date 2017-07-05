<?php

namespace Ignitho\ApiBundle\Handler;

interface ApiHandlerInterface
{
    /**
     * Get a Entity given the identifier
     *
     * @api
     *
     * @param int $id
     *
     * @return ApiInterface
     */
    public function get($id);

    /**
     * Get a list of an Entity
     *
     * @return array
     */
    public function all();

    /**
     * Create a new Entity.
     *
     * @param array $parameters
     *
     * @return Interface
     */
    public function post(array $parameters);
}