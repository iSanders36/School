<?php


use App\Entity\SubDish;
use App\Form\SubDishType;
use App\Repository\SubDishRepository;

class SubDishController
{
    public function index(SubDishRepository $subDishRepository): Response
    {
        return $this->render('sub_dish/index.html.twig', [
            'sub_dishes' => $subDishRepository->findAll(),
        ]);
    }

    public function new(Request $request): Response
    {
        $subDish = new SubDish();
        $form = $this->createForm(SubDishType::class, $subDish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subDish);
            $entityManager->flush();

            return $this->redirectToRoute('sub_dish_index');
        }

        return $this->render('sub_dish/new.html.twig', [
            'sub_dish' => $subDish,
            'form' => $form->createView(),
        ]);
    }

    public function show(SubDish $subDish): Response
    {
        return $this->render('sub_dish/show.html.twig', [
            'sub_dish' => $subDish,
        ]);
    }

    public function edit(Request $request, SubDish $subDish): Response
    {
        $form = $this->createForm(SubDishType::class, $subDish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subdish_index', [
                'id' => $subDish->getId(),
            ]);
        }

        return $this->render('sub_dish/edit.html.twig', [
            'sub_dish' => $subDish,
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request, SubDish $subDish): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subDish->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subDish);
            $entityManager->flush();
        }

        return $this->redirectToRoute('subdish_index');
    }
}
