<?php

namespace App\Controller;

use App\Service\DataFetcher;
use App\Service\DataFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(DataFetcher $dataFetcher, DataFormatter $dataFormatter): Response
    {
//        DataFetcher service send an array of bridge closures data

        $records = $dataFetcher->fetchData();

//        Format the data

        $formattedData=$dataFormatter->formatDataFromApi($records);

//        Return the twig view with the data

        return $this->render('home/index.html.twig', [
            'datas'=>$formattedData
        ]);
    }
}
