<?php
/**
 * This file is part of the PrestaCMSContactBundle
 *
 * (c) PrestaConcept <www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\CMSContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class DefaultController extends Controller
{
    /**
     * Handle form submission
     *
     * @param  Request $request
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function submitAction(Request $request)
    {
        if ($request->getMethod() != 'POST') {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm('presta_cms_contact');
        $form->bind($request);

        if ($form->isValid()) {
            $this->container->get('presta_cms_contact.manager.contact')->handle($form);

            $this->get('session')->setFlash('flash_success', 'form.message.success');
        } else {
            $this->get('session')->setFlash('flash_error', 'form.message.error');
        }

        return $this->render('PrestaCMSContactBundle:Default:submit.html.twig');
    }
}
