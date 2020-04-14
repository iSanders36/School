<?php

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Form\OrderType;

class OrderController
{
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    public function new(Request $request, ProductRepository $productRepository, ReservationRepository $reservationRepository, DishRepository $dishRepository): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        $reservationId = $request->query->get('reservation_id');

        $reservations = null;
        if ($reservationId) {
            $reservations = [$reservationRepository->find($reservationId)];
        } else {
            $reservations = $reservationRepository->findAll();
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $reservationId = $request->request->get("reservation_id");
            $reservation = $reservationRepository->find($reservationId);
            $parameters = $request->request->all();

            $order = new Order();
            $order->setDate(new DateTime());
            $order->setReservation($reservation);
            $entityManager->persist($order);

            foreach ($parameters as $key => $count) {
                if (empty($count) || (strpos($key, "product_") !== 0)) continue;
                $productId = str_replace("product_", "", $key);
                if (!intval($productId)) continue;
                $product = $productRepository->find($productId);
                $orderProduct = new OrderProduct();
                $orderProduct->setProduct($product);
                $orderProduct->setMainOrder($order);
                $orderProduct->setPrice($product->getPrice());
                $orderProduct->setCount($count);
                $entityManager->persist($orderProduct);
            }
            $entityManager->flush();
            return $this->redirectToRoute('order_overview');
        }


        return $this->render('order/new.html.twig', [
            'dishes' => $dishRepository->findAll(),
            'order' => $order,
            'reservations' => $reservations,
            'reservation_id' => $reservationId,
            'form' => $form->createView(),
        ]);
    }

    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    public function edit(Request $request, OrderProductRepository $orderProductRepository): Response
    {
        $parameters = $request->request->all();
        $em = $this->getDoctrine()->getManager();

        foreach ($parameters as $orderProductId => $price) {
            if ($orderProductId === "order_id") continue;
            $orderProduct = $orderProductRepository->find($orderProductId);
            $orderProduct->setPrice($price);
            $em->persist($orderProduct);
        }

        $em->flush();

        return $this->redirectToRoute("order_show", [
            "id" => $request->request->get("order_id")
        ]);
    }

    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_overview');
    }
}
