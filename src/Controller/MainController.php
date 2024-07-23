<?php

namespace App\Controller;


use App\Request\FormPayloadRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{

    public function __construct()
    {
    }

    #[Route('/', name: 'main', methods: ['GET'])]
    public function index(): Response
    {
        $result = isset($result) ? htmlspecialchars($result) : '';

        return $this->render('main/index.html.twig', [
            'result' => $result,
        ]);
    }
}