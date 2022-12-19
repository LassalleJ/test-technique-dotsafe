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
        // Set up a fake 'current day' date

        $fixedDate = new Datetime ('06/11/2022');

//        DataFetcher service sends an array of bridge's closures data

        $records = $dataFetcher->fetchData();

//        Format the data with the service

        $formattedData = $dataFormatter->formatDataFromApi($records, $fixedDate);
        $shownData = $formattedData;

        // Generate the two forms & handle their respective requests

        $searchBoatForm = $this->createForm(SearchBoatType::class);
        $searchDateForm = $this->createForm(SearchDateType::class);

        $searchBoatForm->handleRequest($request);
        $searchDateForm->handleRequest($request);
        $search = '';

        // Handle the form that allows to search for closures at a specific date

        if ($searchDateForm->isSubmitted() && $searchBoatForm->isValid()) {

            $shownData = [];

            // Get the form input and convert it to a string

            $search = $searchDateForm->getData()['Date']->format('d-m-Y');

            // Look for the searched date inside the array of events

            foreach ($formattedData as $data) {
                if ($search === $data['closureHourObject']->format('d-m-Y')) {
                    $shownData[] = $data;
                }
            }
        }

        // Handle the form that allows to search for a passage of a specific boat

        if ($searchBoatForm->isSubmitted() && $searchBoatForm->isValid()) {

            $shownData = [];

            // Get the form input

            $search = $searchBoatForm->getData()['Bateau'];

            foreach ($formattedData as $data) {

                // Convert input and data strings into lowercase

                $searchLowercase = strtolower($search);
                $boatNameLowercase = strtolower($data['reason']);

                // Look for the search string inside the boats array

                if (str_contains($boatNameLowercase, $searchLowercase)) {
                    $shownData[] = $data;
                }
            }
        }

        return $this->render('home/index.html.twig', [
            'datas' => $shownData,
            'dateForm' => $searchDateForm,
            'boatForm' => $searchBoatForm,
            'search' => $search
        ]);
    }
}
