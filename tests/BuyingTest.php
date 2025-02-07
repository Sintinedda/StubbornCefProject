<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BuyingTest extends WebTestCase
{

    public function testAddToCart(): void
    {
       $client = static::createClient();
       $userRepository = static::getContainer()->get(UserRepository::class);
       $testUser = $userRepository->findOneByEmail('user@www.com'); 
       $client->loginUser($testUser);
       $client->followRedirects();

       $crawler = $client->request('GET', '/product/1');
       $crawler = $client->submitForm('AJOUTER AU PANIER', [
            'size' => 'xs'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon panier');
        $this->assertAnySelectorTextContains('p', 'Quantité : 1');
    }

    public function testIncreaseToCart(): void
    {
       $client = static::createClient();
       $userRepository = static::getContainer()->get(UserRepository::class);
       $testUser = $userRepository->findOneByEmail('user@www.com'); 
       $client->loginUser($testUser);
       $client->followRedirects();

       $crawler = $client->request('GET', '/product/1');
       $crawler = $client->submitForm('AJOUTER AU PANIER', [
            'size' => 'xs'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon panier');
        $this->assertAnySelectorTextContains('p', 'Quantité : 1');

        $link = $crawler->selectLink('+')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon panier');
        $this->assertAnySelectorTextContains('p', 'Quantité : 2');
    }

    public function testDecreaseToCart(): void
    {
       $client = static::createClient();
       $userRepository = static::getContainer()->get(UserRepository::class);
       $testUser = $userRepository->findOneByEmail('user@www.com'); 
       $client->loginUser($testUser);
       $client->followRedirects();

       $crawler = $client->request('GET', '/product/1');
       $crawler = $client->submitForm('AJOUTER AU PANIER', [
            'size' => 'xs'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon panier');
        $this->assertAnySelectorTextContains('p', 'Quantité : 1');

        $link = $crawler->selectLink('+')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon panier');
        $this->assertAnySelectorTextContains('p', 'Quantité : 2');

        $link = $crawler->selectLink('-')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon panier');
        $this->assertAnySelectorTextContains('p', 'Quantité : 1');
    }

    public function testDeleteToCartByDecrease(): void
    {
       $client = static::createClient();
       $userRepository = static::getContainer()->get(UserRepository::class);
       $testUser = $userRepository->findOneByEmail('user@www.com'); 
       $client->loginUser($testUser);
       $client->followRedirects();

       $crawler = $client->request('GET', '/product/1');
       $crawler = $client->submitForm('AJOUTER AU PANIER', [
            'size' => 'xs'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon panier');
        $this->assertAnySelectorTextContains('p', 'Quantité : 1');

        $link = $crawler->selectLink('-')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon panier');
        $this->assertAnySelectorTextNotContains('p', 'Quantité : 1');
    }

    public function testDeleteToCart(): void
    {
       $client = static::createClient();
       $userRepository = static::getContainer()->get(UserRepository::class);
       $testUser = $userRepository->findOneByEmail('user@www.com'); 
       $client->loginUser($testUser);
       $client->followRedirects();

       $crawler = $client->request('GET', '/product/1');
       $crawler = $client->submitForm('AJOUTER AU PANIER', [
            'size' => 'xs'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon panier');
        $this->assertAnySelectorTextContains('p', 'Quantité : 1');

        $link = $crawler->selectLink('Retirer du panier')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon panier');
        $this->assertAnySelectorTextNotContains('p', 'Quantité : 1');
    }

    public function testToVerifyCart(): void
    {
       $client = static::createClient();
       $userRepository = static::getContainer()->get(UserRepository::class);
       $testUser = $userRepository->findOneByEmail('user@www.com'); 
       $client->loginUser($testUser);
       $client->followRedirects();

       $crawler = $client->request('GET', '/product/1');
       $crawler = $client->submitForm('AJOUTER AU PANIER', [
            'size' => 'xs'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon panier');
        $this->assertAnySelectorTextContains('p', 'Quantité : 1');

        $link = $crawler->selectLink('Finaliser ma commande')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Vérification de la commande');
    }
}
