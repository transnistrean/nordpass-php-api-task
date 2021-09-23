<?php

namespace App\Tests;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class ItemControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $itemRepository = static::$container->get(ItemRepository::class);

        $user = $userRepository->findOneByUsername('john');

        $client->loginUser($user);

        $data = 'very secure new item data';

        $newItemData = ['data' => $data];

        $client->request('POST', '/item', $newItemData);
        $client->request('GET', '/item');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('very secure new item data', $client->getResponse()->getContent());

        $itemRepository->findOneByData($data);
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $itemRepository = static::$container->get(ItemRepository::class);

        $user = $userRepository->findOneByUsername('john');

        $client->loginUser($user);

        $data = 'very secure new item data';

        $newItemData = ['data' => $data];

        $client->request('POST', '/item', $newItemData);

        $updatedData = 'updated secure item data' . date('Y-m-d h:i:s a');

        /** @var Item $newItem */
        $newItem = $itemRepository->findOneByData($data);

        $updatedItemData = [
            'id' => $newItem->getId(),
            'data' => $updatedData
        ];

        //update item
        $client->request('POST', '/item?_method=PUT', $updatedItemData);
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/item');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString($updatedData, $client->getResponse()->getContent());
    }

    public function testDelete()
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);

        /** @var ItemRepository $itemRepository */
        $itemRepository = static::$container->get(ItemRepository::class);


        $user = $userRepository->findOneByUsername('john');

        $client->loginUser($user);

        $data = 'very secure new item data' . date('Y-m-d h:i:s a');

        $newItemData = ['data' => $data ];


        $client->request('POST', '/item', $newItemData);

        /** @var Item $newItem */
        $newItem = $itemRepository->findOneByData($data);

        $client->request('DELETE', '/item/' . $newItem->getId());
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/item');

        $this->assertResponseIsSuccessful();

        /** @var Item $item */
        $item = $itemRepository->findOneByData($data);

        $this->assertEmpty($item);
    }
}
