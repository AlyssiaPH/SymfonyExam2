<?php


namespace App\Controller;


use Gitlab\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


class DefaultController extends AbstractController
{

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {

        $this->twig = $twig;
    }

    /**
     * @Route ("/", name="home")
     */
    public function index()
    {
        return $this->render('home/home.html.twig');
    }
}