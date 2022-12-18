<?php

namespace App\Controller;

use App\Service\DataFetcher;
use App\Service\DataFormatter;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(DataFetcher $dataFetcher, DataFormatter $dataFormatter): Response
    {
        $fixedDate = new Datetime ('09/11/2022');
//        DataFetcher service sends an array of bridge's closures data

        $records = $dataFetcher->fetchData();

//        Format the data

        $formattedData=$dataFormatter->formatDataFromApi($records, $fixedDate);

//        Return the twig view with the data

        $fixedDateString= $fixedDate->format('d-m-Y');


        return $this->render('home/index.html.twig', [
            'datas'=>$formattedData,
            'dateOfToday'=>$fixedDateString
        ]);
    }
}
