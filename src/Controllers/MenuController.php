<?php

namespace Src\Controllers;

use Src\Models\Menu;
use Src\Validation\Validator;

class MenuController
{
    // Create a new menu item
    public function createMenu()
    {
        $inputData = json_decode(file_get_contents("php://input"), true);
        $errors = Validator::validate($inputData);

        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['errors' => $errors]);
            return;
        }

        $menu = new Menu();
        $menu->name = $inputData['name'];
        $menu->url = $inputData['url'];

        if ($menu->create()) {
            http_response_code(201);
            echo json_encode(['message' => 'Menu item created successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to create menu item']);
        }
    }

    // Retrieve all menu items
    public function getMenu()
    {
        $menu = new Menu();
        $items = $menu->read();

        echo json_encode($items);
    }
}
