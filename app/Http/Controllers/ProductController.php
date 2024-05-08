<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Resources\ProductResource;
use App\Services\ApiResponse;
use App\Services\Product\CreateProductService;
use App\Services\Product\DeleteProductService;
use App\Services\Product\ReadProductService;
use App\Services\Product\UpdateProductService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $response = new ApiResponse();
        try {
            $response->data = ProductResource::collection((new ReadProductService())($request->all()));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }

    /**
     * @param Product $Product
     * @return Response
     */
    public function show(Product $Product): Response
    {
        $response = new ApiResponse();
        try {
            $response->data = (new ProductResource($Product));
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
            'name' => 'required|sometimes|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ]);
        $response = new ApiResponse();
        try {
            $response->data = new ProductResource((new CreateProductService())($request->all()));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }

    /**
     * @param Request $request
     * @param Product $Product
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, Product $Product): Response
    {
        $this->validate($request, [
            'name' => 'sometimes|string|max:255',
            'price' => 'numeric',
            'category_id' => 'exists:categories,id'
        ]);
        $response = new ApiResponse();
        try {
            $response->data = new ProductResource((new UpdateProductService())($request->all(), $Product));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }

    /**
     * @param Product $Product
     * @return Response
     */
    public function destroy(Product $Product): Response
    {
        $response = new ApiResponse();
        try {
            $response->data = new ProductResource((new DeleteProductService())($Product));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }
}
