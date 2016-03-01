<?php

namespace Company\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $service = $this->get('company_user.facade.simple_user');

        $user = $service->createUser($content['name']);

        return new JsonResponse($user);
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $service = $this->get('company_user.facade.simple_user');
        $result  = $service->deleteUser($id);

        return new JsonResponse($result);
    }
}
