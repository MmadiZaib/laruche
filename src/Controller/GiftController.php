<?php

namespace App\Controller;

use App\Services\GiftService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class GiftController extends AbstractFOSRestController
{
    /**
     * @var GiftService
     */
    private $giftService;

    public function __construct(GiftService $giftService)
    {
        $this->giftService = $giftService;
    }

    /**
     * @Rest\Get("/stats", name="gift.stats")
     */
    public function statsAction(): Response
    {
        return $this->json($this->giftService->getGiftStats());
    }

    /**
     * @Rest\Post("/populate", name="gift.populate")
     * @Rest\FileParam(name="gift_file", description="gift file to upload", nullable=false, image=false)
     */
    public function populateAction(ParamFetcher $paramFetcher): Response
    {
        return $this->json($this->giftService->populate($paramFetcher->get('gift_file')));
    }

}
