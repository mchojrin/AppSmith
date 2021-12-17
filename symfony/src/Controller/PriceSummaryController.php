<?php

namespace App\Controller;

use App\Entity\Price;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PriceSummaryController extends AbstractController
{
    #[Route('/price/summary', name: 'price_summary')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $q = $entityManager->createQueryBuilder()
            ->select('pr.date, p.ItemId, pr.amount')
            ->from(Price::class, 'pr')
            ->join('pr.product', 'p')
            ->orderBy('pr.date, pr.product')
            ->getQuery();

        try {
            $result = $q->getResult();

            $data = [];
            if (!empty($result)) {
                $row = current($result);
                while (!empty($row)) {
                    $curDate = $row['date'];
                    $data[$curDate->format('Y-m-d')] = [];
                    while (!empty($row) && $curDate == $row['date']) {
                        $data[$curDate->format('Y-m-d')][$row['ItemId']] = $row['amount'];
                        $row = next($result);
                    }
                }
            }

            return $this->json([
                'sql' => $q->getSQL(),
                'data' => $data,
            ]);
        } catch (\Exception $exception) {
            return $this->json(
                [
                    'error' => $exception->getMessage()
                ],
                500
            );
        }
    }
}
