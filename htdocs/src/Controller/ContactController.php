<?php

namespace App\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator as V;

class ContactController extends BaseController
{
    /**
     * @return array
     */
    private function fields() {
        return [
            'name'     => [
                'rules'   => V::notEmpty(),
                'message' => 'お名前を入力してください。'
            ],
            'email'    => [
                'rules'   => V::notEmpty()->email(),
                'message' => 'メールアドレスを入力してください。'
            ],
            'category' => [
                'rules'   => V::notEmpty(),
                'message' => '題名を選択してください。'
            ],
            'text'     => [
                'rules'   => V::notEmpty(),
                'message' => 'メッセージ本文を入力してください。'
            ]
        ];
    }

    /**
     * @param RequestInterface|\Slim\Http\Request $request
     * @param ResponseInterface|\Slim\Http\Response $response
     *
     * @return ResponseInterface
     */
    protected function index($request, $response)
    {
        if ($request->isPost() &&
            $request->getAttribute('csrf_status') !== false) {
            $this->validator->validate($request, $this->fields());
            if ($this->validator->isValid()) {
                $params = $request->getParams();
                if (isset($params['__confirm'])) {
                    return $this->confirm($request, $response);
                } else if (isset($params['__register'])) {
                    $this->sendmail(
                        'mail/contact_office.twig',
                        $params,
                        $this->settings['email']['office'],
                        $this->settings['email']['from'],
                        'お問い合わせがありました。');

                    $this->sendmail(
                        'mail/contact_user.twig',
                        $params,
                        $params['email'],
                        $this->settings['email']['from'],
                        'お問い合わせありがとうございます。');

                    return $response->withRedirect($this->router->pathFor('contact', ['name' => 'complete']));
                }
            }
        }

        return $this->view->render($response, 'contact/index.twig');
    }

    protected function sendmail($template, $params, $to, $from, $subject)
    {
        $text    = $this->view->fetch($template, [
            'params' => $params
        ]);
        $message = \Swift_Message::newInstance()
                                 ->setTo($to)
                                 ->setFrom($from)
                                 ->setSubject($subject)
                                 ->setBody($text);
        $this->mailer->send($message);
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    protected function confirm($request, $response)
    {
        return $this->view->render($response, 'contact/confirm.twig');
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    protected function complete($request, $response)
    {
        return $this->view->render($response, 'contact/complete.twig');
    }
}