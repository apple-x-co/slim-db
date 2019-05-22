<?php

namespace App\Controller;

use App\Model\User;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator as V;

class UsersController
{
    /** @var \Slim\Views\Twig */
    protected $view;

    /** @var \Illuminate\Database\Capsule\Manager */
    protected $db;

    /**
     * UsersController constructor.
     *
     * @param $view
     * @param $db
     */
    public function __construct($view, $db) {
        $this->view = $view;
        $this->db = $db;
    }

    /**
     * @param RequestInterface|\Slim\Http\Request $request
     * @param ResponseInterface|\Slim\Http\Response $response
     * @param array $args
     *
     * @return ResponseInterface
     */
    public function index($request, $response, $args)
    {
        $users = User::all();

        return $this->view->render($response, 'users/index.twig', [
            'users' => $users
        ]);
    }

    /**
     * @param RequestInterface|\Slim\Http\Request $request
     * @param ResponseInterface|\Slim\Http\Response $response
     * @param array $args
     *
     * @return ResponseInterface
     */
    public function detail($request, $response, $args)
    {
        $id = $args['id'];

        return $this->view->render($response, 'users/detail.twig');
    }
}