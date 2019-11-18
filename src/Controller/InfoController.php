<?php

namespace App\Controller;

use App\Entity\Info;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InfoController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $info = $this->getDoctrine()->getRepository(Info::class)->findAll();
        return $this->render('info/index.html.twig',
            [
                'Data' => $info
            ]);
    }

    /**
     * @Route("/Insert", name="info_insert")
     */
    public function INSERT(Request $request)
    {
        if ($request->getMethod() == "POST"){
            $em = $this->getDoctrine()->getManager();
            $info = new Info();
            $info->setName($request->get('name'));
            $info->setBrand($request->get('brand'));
            $info->setReference($request->get('reference'));
            $info->setStock($request->get('stock'));
            $info->setEnddate($request->get('date'));
            $em->persist($info);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        return $this->render('info/insert.html.twig');
    }

    /**
     * @Route("/Update/{id}", name="info_update")
     */
    public function UPDATE(Request $request, $id)
    {
        $data = $this->getDoctrine()->getRepository(Info::class)->find($id);
        if ($request->getMethod() == "POST"){
            $em = $this->getDoctrine()->getManager();
            $info = $em->getRepository(Info::class)->find($id);
            $info->setName($request->get('name'));
            $info->setBrand($request->get('brand'));
            $info->setReference($request->get('reference'));
            $info->setStock($request->get('stock'));
            $info->setEnddate($request->get('date'));
            $em->persist($info);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        return $this->render('info/update.html.twig',
            [
                'Data' => $data
            ]);
    }


    /**
     * @Route("/Delete/{id}", name="info_remove")
     */
    public function DELETE($id)
    {
        $em = $this->getDoctrine()->getManager();
        $info = $em->getRepository(Info::class)->find($id);
        $em->remove($info);
        $em->flush();
        return $this->redirectToRoute('homepage');
    }


}
