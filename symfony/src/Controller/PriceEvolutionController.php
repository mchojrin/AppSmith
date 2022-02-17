<?php

namespace App\Controller;

use App\Entity\Price;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PriceEvolutionController extends AbstractController
{
    #[Route('/price/evolution', name: 'price_summary')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $qb = $entityManager->createQueryBuilder()
            ->select('p.source, pr.date, pr.amount')
            ->from(Price::class, 'pr')
            ->join('pr.product', 'p')
            ->orderBy('p.source, pr.date');

        if ($source = $request->get('source')) {
            $qb
                ->where('p.source = :source')
                ->setParameter('source', $source)
                ;
        }

        $q = $qb->getQuery();

        try {
            $result = $q->getResult();

            if (empty($result)) {
                return $this->json([
                    'sql' => $q->getSQL(),
                    'data' => [],
                ]);
            }

            $data = [];
            $row = current($result);
            while (!empty($row)) {
                $curSource = $row['source'];
                $data[$curSource] = [];
                while (!empty($row) && $curSource == $row['source']) {
                    $data[$curSource][] = [
                        'x' => $row['date']->format('Y-m-d'),
                        'y' => $row['amount']
                    ];
                    $row = next($result);
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
