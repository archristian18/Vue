<?php

namespace App\Services\API;

use DB;
use Exception;
use App\Models\Menu;
use App\Http\Resources\MenuResource;
use App\Exceptions\MenuNotFoundException;

class MenuService
{
    /** @var \App\Models\Menu */
    protected $menu;

    public function __construct(Menu $menu)
    {   
        $this->menu = $menu;
    }

    public function getAllMenu()
    {
        $menu = $this->menu->get();

        foreach ($menu as &$item) {
            $item['image_path'] = asset($item['image_path']);
        }

        return $menu;
    }

    public function create(array $params): Menu
    {
        DB::beginTransaction();

        try {
            // Assuming you have an 'image' field in your form for image upload
            if (isset($params['image_path'])) {
                // Get the uploaded image file
                $image = $params['image_path'];

                // Generate a unique file name
                $imageName = time() . '_' . $image->getClientOriginalName();

                // Store the image in the public directory
                $image->storeAs('public/images', $imageName);

                // Update the 'image_path' in the parameters to the saved image path
                $params['image_path'] = 'storage/images/' . $imageName;

            }   

            // Set other attributes
            $menus = $this->menu->create($params);

            // Save the record
            // $menus->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }

        return $menus;
    }

    public function findByMenu(int $id): Menu
    {
        $menu = $this->menu->find($id);

        if (!($menu instanceof Menu)) {  
            throw new MenuNotFoundException();
        }
        
        return $menu;
    }

    public function delete(int $id)
    {
        $menu = $this->findByMenu($id);
        $menu->delete();

        return true;
    }

    public function update(array $params)
    {
        DB::beginTransaction();

        try {
            // Retrieve the menu item by ID
            $menu = $this->menu->findOrFail($params['id']);
            // Assuming you have an 'image' field in your form for image upload
            if ($params['image_path'] !== null) {
                // Get the uploaded image file
                $image = $params['image_path'];
    
                // Generate a unique file name
                $imageName = time() . '_' . $image->getClientOriginalName();
    
                // Store the image in the public directory
                $image->storeAs('public/images', $imageName);
    
                // Update the 'image_path' in the parameters to the saved image path
                $params['image_path'] = 'storage/images/' . $imageName;

                $menu->update([
                    'name' => $params['name'],
                    'price' => $params['price'],
                    'description' => $params['description'],
                    'image_path' => $params['image_path'],
                ]);
            }
    
            // Update the menu item with the provided parameters
            $menu->update([
                'name' => $params['name'],
                'price' => $params['price'],
                'description' => $params['description'],
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
    
            throw $e;
        }
    
        return $menu;
    }
    
}
