<?php

namespace App\Controller;

use App\Repository\CarRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/dashboard', name: 'admin_dashboard')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/users', name: 'admin_users', methods: ['GET'])]
    public function users(Request $request, UserRepository $userRepository): Response
    {
        $searchTerm = $request->query->get('search', null);
        $users = $userRepository->search(20, $searchTerm);

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/users/{id}/delete', name: 'admin_user_delete', methods: ['POST'])]
    public function deleteUser($id, UserService $userService): Response
    {
        try {
            $userService->deleteUser($id);
            $this->addFlash('success', 'Utilisateur supprimé');
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('admin_users');
    }

    #[Route('/cars', name: 'admin_cars', methods: ['GET'])]
    public function cars(Request $request, CarRepository $carRepository): Response
    {
        $searchTerm = $request->query->get('search', null);
        $cars = $carRepository->search(20, $searchTerm);

        return $this->render('admin/cars.html.twig', [
            'cars' => $cars,
        ]);
    }

    #[Route('/reservations', name: 'admin_reservations', methods: ['GET'])]
    public function reservations(ReservationRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->search();

        return $this->render('admin/reservations.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}
