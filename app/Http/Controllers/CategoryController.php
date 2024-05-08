<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Resources\CategoryResource;
use App\Services\ApiResponse;
use App\Services\Category\CreateCategoryService;
use App\Services\Category\DeleteCategoryService;
use App\Services\Category\ReadCategoryService;
use App\Services\Category\UpdateCategoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $response = new ApiResponse();
        try {
            $response->data = CategoryResource::collection((new ReadCategoryService())($request->all()));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }

    /**
     * @param Category $Category
     * @return Response
     */
    public function show(Category $Category): Response
    {
        $response = new ApiResponse();
        try {
            $response->data = (new CategoryResource($Category));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request): Response
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);
        $response = new ApiResponse();
        try {
            $response->data = new CategoryResource((new CreateCategoryService())($request->all()));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }

    /**
     * @param Request $request
     * @param Category $Category
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, Category $Category): Response
    {
        $this->validate($request, [
            'name' => 'sometimes|string|max:255',
        ]);
        $response = new ApiResponse();
        try {
            $response->data = new CategoryResource((new UpdateCategoryService())($request->all(), $Category));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }

    /**
     * @param Category $Category
     * @return Response
     */
    public function destroy(Category $Category): Response
    {
        $response = new ApiResponse();
        try {
            $response->data = new CategoryResource((new DeleteCategoryService())($Category));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }
}
