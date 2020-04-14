<?php

use App\Repository\OrderRepository;
use App\Repository\ReservationRepository;

class ListController
{
    public function cookList(OrderRepository $orderRepository)
    {
        $order = $orderRepository->findAll()[0];
        $orderedProducts = $order->getOrderProducts();

        return $this->render('list/cook.html.twig', [
            'order' => $order,
            "products" => $orderedProducts
        ]);
    }

    public function bonList(Request $request, $id, ReservationRepository $reservationRepository)
    {
        $reservation = $reservationRepository->find($id);
        $orders = $reservation->getOrders();
        $orderedProducts = [];
        $totalPrice = 0;
        foreach ($orders as $order) {
            $orderedProducts = $order->getOrderProducts();
            foreach ($orderedProducts as $product) {
                $totalPrice += $product->getProduct()->getPrice();
            }
        }
        return $this->render('list/bon.html.twig', [
            'reservation' => $reservation,
            'products' => $orderedProducts,
            'totalPrice' => number_format($totalPrice, 2),
        ]);
    }

    public function pdf(Request $request, $id, ReservationRepository $reservationRepository)
    {
        $reservation = $reservationRepository->find($id);
        $payed = $request->query->get("customer_payed");

        $orders = $reservation->getOrders();
        $orderedProducts = [];
        $totalPrice = 0;
        foreach ($orders as $order) {
            $orderedProducts = $order->getOrderProducts();
            foreach ($orderedProducts as $product) {
                $totalPrice += $product->getProduct()->getPrice();
            }
        }

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsHtml5ParserEnabled(true);

        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('list/bon-pdf.html.twig', [
            'reservation' => $reservation,
            'products' => $orderedProducts,
            'totalPrice' => number_format($totalPrice, 2)
        ]);
        dump($html);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfName = "BON-{$reservation->getId()}-{$reservation->getTableId()}-{$reservation->getCustomer()->getPhone()}.pdf";

        $dompdf->stream($pdfName, [
            "Attachment" => false
        ]);
    }

    public function invalidBonListHandler()
    {
        return $this->redirectToRoute('reservation_overview');
    }
}
