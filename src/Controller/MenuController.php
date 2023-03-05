<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\Menu1Type;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/menu')]
class MenuController extends AbstractController
{
    #[Route('/', name: 'app_menu_index', methods: ['GET'])]
    public function index(MenuRepository $menuRepository): Response
    {
        return $this->render('menu/menu.html.twig', [
            'menus' => $menuRepository->findAll(),
        ]);
    }

    #[Route("/allmenu", name: "listmenu")]
    public function getMenus(MenuRepository $repo, SerializerInterface $serializer)
    {
        $menus = $repo->findAll();
        $json = $serializer->serialize($menus, 'json', ['groups' => "menu"]);
        $json1=json_encode($menus);
        dd($json1);
        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON

        die;
        return $this->render('menu/menu.html.twig', [
            'menus' => $repo->findAll(),
         ]);
    }


    #[Route('/new', name: 'app_menu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MenuRepository $menuRepository, SluggerInterface $slugger): Response
    {
        $menu = new Menu();
        $form = $this->createForm(Menu1Type::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $photo = $form->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('menu_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $menu->setImage($newFilename);
            }

            $menuRepository->save($menu, true);

            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('menu/new.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_menu_show', methods: ['GET'])]
    public function show(Menu $menu): Response
    {
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_menu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Menu $menu, MenuRepository $menuRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(Menu1Type::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $photo = $form->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('menu_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $menu->setImage($newFilename);
            }

            $menuRepository->save($menu, true);

            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_menu_delete', methods: ['POST'])]
    public function delete(Request $request, Menu $menu, MenuRepository $menuRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
            $menuRepository->remove($menu, true);
        }

        return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
    }
}




// zedna 2 use  ou hedha  

// #[Route("/allplat", name: "listplat")]
// public function getPlats(PlatRepository $repo, SerializerInterface $serializer)
// {
//     $plats = $repo->findAll();
//     $json = $serializer->serialize($plats, 'json', ['groups' => "plat"]);
//     $json1=json_encode($plats);
//     dd($json1);
//     //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON

//     die;
//     return $this->render('plat/plat.html.twig', [
//         'plats' => $repo->findAll(),
//      ]);
// } 