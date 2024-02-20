<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Http\Controllers\Controller;
use App\Services\API\MenuService;
use App\Http\Resources\MenuResource;
use App\Http\Requests\API\Menu\CreateMenuRequest;
use App\Http\Requests\API\Menu\EditMenuRequest;

class MenuController extends Controller
{
    /** @var \App\Services\API\MenuService */
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        parent::__construct();
        $this->menuService = $menuService;
    }
    /**
     * Retrieves user information
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function getMenuList()
    {
        try {
            $menu = $this->menuService->getAllMenu();
            $this->response['data'] = $menu;
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    /**
     * Create New Customer Order
     *
     * @param \App\Http\Requests\API\Customer\CreateMenuRequest $request
     * 
     */
    public function create(CreateMenuRequest $request)
    {
        $request->validated();
        try {
            $formData = [
                'name' => $request->getName(),
                'price' => $request->getPrice(),
                'description' => $request->getDescription(),
                'image_path' => $request->getImage(),
            ];
            $menu = $this->menuService->create($formData);
            $this->response['data'] = new MenuResource($menu);

        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    public function getMenu($id)
    {
        try {
            $menu = $this->menuService->findByMenu($id);
            $this->response['data'] = new MenuResource($menu);
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    public function delete($id)
    {
        try {
            $this->response['deleted'] = $this->menuService->delete((int) $id);
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    public function getEdit(EditMenuRequest $request)
    {
        $request->validated();
        try {
            $formData = [
                'id' => $request->getId(),
                'name' => $request->getName(),
                'price' => $request->getPrice(),
                'description' => $request->getDescription(),
                'image_path' => $request->getImage(),
            ];
            
            $menu = $this->menuService->update($formData);
            $this->response['data'] = new MenuResource($menu);

        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }
    
}
