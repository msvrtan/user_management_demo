<?php

namespace Company\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GroupController.
 */
class GroupController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        try {
            $service = $this->get('company_user.facade.simple_group');

            $group = $service->createGroup($content['groupName']);
        } catch (\Exception $e) {
            $group = $e->getMessage();
        }

        return new JsonResponse($group);
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $service = $this->get('company_user.facade.simple_group');
        $result  = $service->deleteGroup($id);

        return new JsonResponse($result);
    }

    /**
     * @param $id
     * @param $userId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addUserAction($id, $userId)
    {
        $service = $this->get('company_user.facade.simple_group');

        $group = $this->getSimpleGroupRepo()->find($id);
        $user  = $this->getSimpleUserRepo()->find($userId);

        if (empty($group) || empty($user)) {
            $result = false;
        } else {
            $result = $service->addUserToGroup($group, $user);
        }

        return new JsonResponse($result);
    }

    /**
     * @param $id
     * @param $userId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeUserAction($id, $userId)
    {
        $service = $this->get('company_user.facade.simple_group');

        $group = $this->getSimpleGroupRepo()->find($id);
        $user  = $this->getSimpleUserRepo()->find($userId);

        if (empty($group) || empty($user)) {
            $result = false;
        } else {
            $result = $service->removeUserFromGroup($group, $user);
        }

        return new JsonResponse($result);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getSimpleUserRepo()
    {
        return $this->getDoctrine()->getRepository('CompanyUserBundle:SimpleUser');
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getSimpleGroupRepo()
    {
        return $this->getDoctrine()->getRepository('CompanyUserBundle:SimpleGroup');
    }
}
