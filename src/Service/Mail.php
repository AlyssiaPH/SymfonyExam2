<?php


namespace App\Service;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Gitlab\Client;

class Mail
{
    /**
     * Property add Environment twig
     * @var Environment
     */
    private $renderer;
    private $mergeRequest;
    private $mailer;

    public function __construct(Environment $renderer, Client $mergeRequest, \Swift_Mailer $mailer)
    {
        $this->renderer = $renderer;
        $this->mergeRequest = $mergeRequest;
        $this->mailer = $mailer;
    }

    public function index()
    {
        $message = (new \Swift_Message('Merge request'))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody(
                $this->renderer->render(
                // templates/emails/registration.html.twig
                    'emails/mail.html.twig',
                    ['mergeRequests' => $this->mergeRequest->mergeRequests()->all()]
                ),
                'text/html'
            );

        $this->mailer->send($message);
/*
        return $this->render(...);*/
    }
}