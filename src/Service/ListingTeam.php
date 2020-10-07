<?php

use Twig\Environment;

Class ListingTeam
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
}

?>