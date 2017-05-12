<?php

namespace AppBundle\Controller;

use AppBundle\Services\ValidationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PollController
 * @package AppBundle\Controller
 */
class PollController extends Controller
{
    /**
     * @Route("/backoffice/polls", name="backoffice_polls")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $service = $this->get('app.pollRepositoryService');
        $polls = $service->getPolls([]);
        // replace this example code with whatever you need
        return $this->render('@App/backoffice/poll/index.html.twig', [
            'polls' => $polls,
        ]);
    }

    /**
     * @Route("/backoffice/polls/add", name="backoffice_polls_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        /** @var ValidationService $validationService */
        $validationService = $this->get('app.validationService');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($request->getMethod() == 'POST') {
            $errors = $validationService->validateAndCreatePollFromRequest($request, $user);
            if (count($errors) > 0) {
                dump($errors);
                die();
            } else {
                return $this->redirect($this->generateUrl('backoffice_polls'));
            }
        }
        return $this->render('@App/backoffice/poll/add.html.twig');
    }

    /**
     * @Route("/backoffice/polls/{id}/edit", name="backoffice_poll_edit")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $service = $this->get('app.pollRepositoryService');
        $poll = $service->getJsonPoll($id);

        $validationService = $this->get('app.validationService');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($request->getMethod() == 'POST') {
            $errors = $validationService->validateAndCreatePollFromRequest($request, $user);
            if (count($errors) > 0) {
                dump($errors);
                die();
            } else {
                return $this->redirect($this->generateUrl('backoffice_polls'));
            }
        }

        return $this->render('@App/backoffice/poll/edit.html.twig', [
            'poll' => $poll
        ]);
    }

    /**
     * @Route("/backoffice/polls/{id}/delete", name="backoffice_poll_delete")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $service = $this->get('app.pollRepositoryService');
        try {
            $service->deleteById(['id' => $id]);
            return $this->redirect($this->generateUrl('backoffice_polls'));
        } catch (\Exception $e) {
            dump($e->getMessage());
            dump("can't create");
            die();
        }
    }
}