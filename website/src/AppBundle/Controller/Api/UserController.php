<?php

namespace AppBundle\Controller\Api;

use AppBundle\Services\ApiAuthService;
use AppBundle\Services\PollRepositoryService;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;

/**
 * Class UserController
 * @package AppBundle\Controller\Api
 */
class UserController extends FOSRestController
{

    /**
     * @View(serializerGroups={"Default", "Details"})
     * @param $id
     * @return array
     */
    public function getUserPollsAction($id)
    {
        /** @var ApiAuthService $authService */
        $authService = $this->get('app.apiAuthService');
        $authService->checkToken();
        /** @var PollRepositoryService $pollRepository */
        $pollRepository = $this->get('app.pollrepositoryservice');
        $polls = $pollRepository->getPolls(['user_id' => $id]);
        return $polls;
    }
}
