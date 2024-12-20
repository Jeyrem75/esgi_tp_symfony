<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Entity\Step;
use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];
        $roles = ['ROLE_ADMIN', 'ROLE_USER', 'ROLE_BANNED'];
        foreach ($roles as $key => $role) {
            $user = new User();
            $user->setUsername('Username' . ($key + 1));
            $user->setEmail(strtolower($role) . '@example.com');
            $user->setRoles([$role]);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $manager->persist($user);
            $users[$role] = $user;
        }

        $ingredientNames = ['Flour', 'Sugar', 'Butter', 'Eggs', 'Milk', 'Cocoa Powder'];
        $ingredients = [];
        foreach ($ingredientNames as $name) {
            $ingredient = new Ingredient();
            $ingredient->setName($name);
            $ingredient->setQuantity(rand(100, 500));
            $ingredient->setUnit('grams');
            $manager->persist($ingredient);
            $ingredients[] = $ingredient;
        }

        $recipes = [];
        for ($i = 1; $i <= 3; $i++) {
            $recipe = new Recipe();
            $recipe->setTitle("Recipe $i");
            $recipe->setDescription("Description for Recipe $i.");
            $recipe->setDuration(rand(30, 120));
            $recipe->setDifficulty(['Easy', 'Medium', 'Hard'][array_rand(['Easy', 'Medium', 'Hard'])]);

            foreach (array_rand($ingredients, rand(3, 5)) as $key) {
                $recipe->addIngredient($ingredients[$key]);
            }

            $recipe->setUser($users['ROLE_USER']);

            $manager->persist($recipe);
            $recipes[] = $recipe;
        }

        foreach ($recipes as $recipe) {
            for ($stepNumber = 1; $stepNumber <= rand(3, 5); $stepNumber++) {
                $step = new Step();
                $step->setNumber($stepNumber);
                $step->setDescription("Step $stepNumber for {$recipe->getTitle()}.");
                $step->setRecipe($recipe);
                $manager->persist($step);
            }
        }

        foreach ($recipes as $recipe) {
            for ($j = 1; $j <= rand(2, 4); $j++) {
                $review = new Review();
                $review->setRating(rand(1, 5));
                $review->setComment("This is a comment for {$recipe->getTitle()}.");
                $review->setRecipe($recipe);

                $review->setUser($users['ROLE_USER']);
                $manager->persist($review);
            }
        }

        $manager->flush();
    }
}
