<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Review;
use App\Form\RecipeAddType;
use App\Form\RecipeSearchType;
use App\Form\ReviewAddType;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recipe')]
final class RecipeController extends AbstractController
{
    #[Route('', name: 'app_recipe_list', methods: ['GET', 'POST'])]
    public function list(Request $request, RecipeRepository $recipeRepository, IngredientRepository $ingredientRepository): Response
    {
        $searchData = [];
        $allIngredients = $ingredientRepository->findAll();
        $ingredientChoices = [];
        foreach ($allIngredients as $ingredient) {
            $ingredientChoices[$ingredient->getName()] = $ingredient->getName();
        }

        $form = $this->createForm(RecipeSearchType::class, $searchData, [
            'method' => 'GET',
            'ingredients' => $ingredientChoices,
        ]);

        // $form = $this->createForm(RecipeSearchType::class);
        $form->handleRequest($request);

        $recipes = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form->getData();
            $recipes = $recipeRepository->findByCriteria($criteria);
        } else {
            $recipes = $recipeRepository->findAll();
        }

        return $this->render('recipe/list.html.twig', [
            'recipes' => $recipes,
            'searchForm' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_recipe_add', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour ajouter une recette.');
        }

        $recipe = new Recipe();
        $recipe->setUser($user);

        $form = $this->createForm(RecipeAddType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recipe);
            $entityManager->flush();

            $this->addFlash('success', 'La recette a été ajoutée avec succès.');

            return $this->redirectToRoute('app_recipe_list');
        }

        return $this->render('recipe/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_recipe_detail', methods: ['GET', 'POST'])]
    public function detail(Request $request, Recipe $recipe, EntityManagerInterface $entityManager): Response
    {
        $review = new Review();
        $review->setRecipe($recipe);
        $review->setUser($this->getUser());

        $form = $this->createForm(ReviewAddType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($review);
            $entityManager->flush();

            $this->addFlash('success', 'Votre commentaire a été ajouté.');
            return $this->redirectToRoute('app_recipe_detail', ['id' => $recipe->getId()]);
        }
        return $this->render('recipe/detail.html.twig', [
            'recipe' => $recipe,
            'steps' => $recipe->getSteps(),
            'ingredients' => $recipe->getIngredients(),
            'reviews' => $recipe->getReviews(),
            'form' => $form->createView(),
        ]);
    }
}
