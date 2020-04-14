<?php

use App\Entity\Customer;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\CustomerRepository;
use App\Repository\ReservationRepository;

class ReservationController
{
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    public function new(Request $request, CustomerRepository $customerRepository): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $customer = $customerRepository->findOneBy([
                "Phone" => $request->request->get("customer_phone"),
                "Name" => $request->request->get("customer_name")
            ]);
            if ($customer === null) {
                $customer = new Customer();
                $customer->setName($request->request->get("customer_name"));
                $customer->setPhone($request->request->get("customer_phone"));
                $entityManager->persist($customer);
            }

            $reservation->setCustomer($customer);
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_overview');
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    public function show(Reservation $reservation): Response
    {
        $orders = $reservation->getOrders();
        $orderedProducts = [];
        foreach ($orders as $order) {
            $orderedProducts = $order->getOrderProducts();
        }
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'products' => $orderedProducts,
            'orders' => $reservation->getOrders()
        ]);
    }

    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_overview', [
                'id' => $reservation->getId(),
            ]);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_overview');
    }
}
