<?php


use App\Entity\Receipt;
use App\Form\ReceiptType;
use App\Repository\ReceiptRepository;
use App\Repository\ReservationRepository;

class ReceiptController extends AbstractController
{
    public function index(ReceiptRepository $receiptRepository): Response
    {
        return $this->render('receipt/index.html.twig', [
            'receipts' => $receiptRepository->findAll(),
        ]);
    }

    public function new(Request $request, ReservationRepository $reservationRepository): Response
    {
        $receipt = new Receipt();

        $reservationId = $request->request->get("reservation_id");
        $payed = $request->request->get("payed");

        if (!$reservationId) throw new Exception("Invalid reservation id", 400);

        $reservation = $reservationRepository->find($reservationId);

        if (!$reservation) throw new Exception("Invalid reservation id", 400);

        $receipt->setPayed($payed);
        $receipt->setReservation($reservation);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($receipt);
        $entityManager->flush();

        return $this->redirectToRoute("list_bon", [
            "id" => $reservation->getId()
        ]);
    }

    public function show(Receipt $receipt): Response
    {
        return $this->render('receipt/show.html.twig', [
            'receipt' => $receipt,
        ]);
    }

    public function edit(Request $request, Receipt $receipt): Response
    {
        $form = $this->createForm(ReceiptType::class, $receipt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('receipt_index', [
                'id' => $receipt->getId(),
            ]);
        }

        return $this->render('receipt/edit.html.twig', [
            'receipt' => $receipt,
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request, Receipt $receipt): Response
    {
        if ($this->isCsrfTokenValid('delete'.$receipt->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($receipt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('receipt_index');
    }
}
