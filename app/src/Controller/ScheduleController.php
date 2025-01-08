<?php

namespace App\Controller;

use App\DTO\Query\RepaymentQueryFilter;
use App\Entity\LoanCalculation;
use App\Entity\User;
use App\Repository\LoanCalculationRepository;
use App\Service\CalculatedRepaymentScheduleResponseBuilder;
use App\Service\CalculateRepaymentScheduleService;
use App\Service\LoanCalculationResponseBuilder;
use Doctrine\ORM\EntityManagerInterface;
use DTO\Payload\CalculateRepaymentSchedule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ScheduleController extends AbstractController
{
    #[Route('/api/repayment_schedule', name: 'repayment_schedule', methods: ['POST'])]
    public function calculateRepaymentSchedule(
        #[MapRequestPayload] CalculateRepaymentSchedule $calculateRepaymentSchedule,
        CalculateRepaymentScheduleService               $calculateRepaymentScheduleService,
        CalculatedRepaymentScheduleResponseBuilder      $calculatedRepaymentScheduleBuilder,
    ): JsonResponse
    {
        try {
            $repaymentSchedule = $calculateRepaymentScheduleService->calculateRepaymentSchedule($calculateRepaymentSchedule);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($calculatedRepaymentScheduleBuilder->buildResponse($repaymentSchedule)->getReponseArray(), Response::HTTP_OK);
    }

    #[Route('/api/repayment_schedule/{id}/exclude', name: 'exclude_repayment_schedule', methods: ['PATCH'])]
    public function excludeSingleCalculation(
        EntityManagerInterface $entityManager,
        #[CurrentUser] ?User   $user,
        LoanCalculation        $loanCalculation,
    ): JsonResponse
    {
        if (!$user) {
            return new JsonResponse('You must me Authorized to exclute calculation', Response::HTTP_UNAUTHORIZED);
        }
        if (!$loanCalculation) {
            return new JsonResponse('Entity not found', Response::HTTP_BAD_REQUEST);
        }

        $loanCalculation->setExcluded(true);
        $entityManager->flush();

        return new JsonResponse('Calculation excluded', Response::HTTP_OK);
    }

    #[Route('/api/repayment_schedules', name: 'get_latest_repayment_schedules', methods: ['GET'])]
    public function getLatestCalculations(
        #[CurrentUser] ?User   $user,
        #[MapQueryString()] RepaymentQueryFilter $filter,
        LoanCalculationResponseBuilder           $loanCalculationsBuilder,
        LoanCalculationRepository                $loanCalculationRepository,
    ): JsonResponse
    {
        if (!$user) {
            return new JsonResponse('You must me Authorized to see calculations', Response::HTTP_UNAUTHORIZED);
        }
        $loandCalculations = $loanCalculationRepository->getLastCalcualtions($filter->filter, 4);

        return new JsonResponse($loanCalculationsBuilder->buildResponse($loandCalculations), Response::HTTP_OK);
    }
}
