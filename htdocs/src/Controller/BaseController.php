<?php

namespace App\Controller;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class BaseController
{
    /** @var \Slim\Collection */
    protected $settings;

    /** @var \Slim\Router */
    protected $router;

    /** @var \Slim\Views\Twig */
    protected $view;

    /** @var \Respect\Validation\Validator */
    protected $validator;

    /** @var \Swift_Mailer */
    protected $mailer;

    /**
     * RecruitController constructor.
     *
     * @param \Slim\Container $container
     *
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct($container)
    {
        $this->settings  = $container->get('settings');
        $this->router    = $container->get('router');
        $this->view      = $container->get('view');
        $this->validator = $container->get('validator');
        $this->mailer    = $container->get('mailer');
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param $argument
     *
     * @return ResponseInterface
     * @throws \Slim\Exception\NotFoundException
     */
    public function __invoke($request, $response, $argument)
    {
        $method_name = isset($argument['name']) ? $argument['name'] : 'index';

        if (method_exists($this, $method_name)) {
            return $this->$method_name($request, $response);
        }

        throw new \Slim\Exception\NotFoundException($request, $response);
    }
}