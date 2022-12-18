<?php

namespace App\Controller;

use App\Form\SearchBoatType;
use App\Form\SearchDateType;
use App\Service\DataFetcher;
use App\Service\DataFormatter;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(DataFetcher $dataFetcher, DataFormatter $dataFormatter, Request $request): Response
    {
        $searchedData = [];
        $fixedDate = new Datetime ('09/11/2022');
//        DataFetcher service sends an array of bridge's closures data

        $records = $dataFetcher->fetchData();

//        Format the data

        $formattedData = $dataFormatter->formatDataFromApi($records, $fixedDate);
        $shownData = $formattedData;

//        Return the twig view with the data

        $fixedDateString = $fixedDate->format('d-m-Y');

        $searchBoatForm = $this->createForm(SearchBoatType::class);
        $searchDateForm = $this->createForm(SearchDateType::class);

        $searchBoatForm->handleRequest($request);
        $searchDateForm->handleRequest($request);
        $search = '';

        if ($searchDateForm->isSubmitted()) {
            $shownData = [];
            $search = $searchDateForm->getData()['Date']->format('d-m-Y');
            foreach ($formattedData as $data) {
                if ($search === $data['reOpenHourObject']->format('d-m-Y')) {
                    $shownData[] = $data;
                }
            }
        }

        if ($searchBoatForm->isSubmitted() && $searchBoatForm->isValid()) {
            $shownData = [];
            $search = $searchBoatForm->getData()['Bateau'];
            foreach ($formattedData as $data) {
                $searchLowercase=strtolower($search);
                $boatNameLowercase=strtolower($data['reason']);
                if (str_contains($boatNameLowercase, $searchLowercase)) {
                    $shownData[] = $data;
                }
            }
        }

        return $this->render('home/index.html.twig', [
            'datas' => $shownData,
            'dateOfToday' => $fixedDateString,
            'dateForm' => $searchDateForm,
            'boatForm' => $searchBoatForm,
            'search' => $search
        ]);
    }
}
