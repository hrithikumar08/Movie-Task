<?php

namespace App\Controller;

use Symfony\Component\Console\Color;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{

    #[Route('/hello1', name: 'hello_world')]
    public function hello(): Response
    {
        // int $max

        $max = 10;
        $number = random_int(0, $max);

        return new Response(
            '<html><body style="color:red;background-color:grey;">Lucky number: '.$number.'</body></html>'
        );

    }

    #[Route('/success_page', name: 'success')]
    public function success(): Response
    {

        return new Response(
            '<html><body style="color:red;"><h1>Movies Lists Loading... </h1></body></html>'
        );

    }

  
   

}

?>
