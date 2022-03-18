<?php

namespace App\Controller\Admin;

use App\Entity\Hotel;
use App\Entity\Reservation;
use App\Entity\Room;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_MANAGER')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($adminUrlGenerator->setController(HotelCrudController::class)->generateUrl());
        } else {
            return $this->redirect($adminUrlGenerator->setController(RoomCrudController::class)->generateUrl());
        }
        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dashboard Hypnos Hotel');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section("Administrator Section")
            ->setPermission('ROLE_SUPER_ADMIN');
        yield MenuItem::linkToCrud('Manager', 'fas fa-user', User::class)
            /* ->setPermission('ROLE_SUPER_ADMIN') */;
        yield MenuItem::linkToCrud('Hotel', 'fas fa-hotel', Hotel::class)
            ->setPermission('ROLE_SUPER_ADMIN');
        yield MenuItem::section("Manager Section");
        yield MenuItem::linkToCrud('Room', 'fas fa-bed', Room::class);
        yield MenuItem::linkToCrud('Reservation', 'fas fa-calendar', Reservation::class);
    }
}
