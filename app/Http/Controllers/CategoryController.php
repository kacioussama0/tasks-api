<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function index()
    {
        return Auth::user()->categories;
    }


    public function store(Request $request)
    {
        $validatedData = $request -> validate([
            'title' => 'required',
            'description' => 'min:10|max:100',
        ]);

        $user = Auth::user();



        $created = $user -> categories()->create($validatedData);

        if($created) {
            return $created;
        }

        return response()->json(['message' => 'some error happened'],500);

    }


    public function show(Category $category)
    {
        if(auth()->id() != $category -> user_id) {
            return response()->json(['message' => 'you do not have any access to this resource'],401);

        }
        return $category;
    }


    public function update(Request $request, Category $category)
    {

        if(auth()->id() != $category -> user_id) {
            return response()->json(['message' => 'you do not have any access to this resource'],401);

        }

        $validatedData = $request -> validate([
            'title' => 'required',
            'description' => 'min:10|max:100'
        ]);

        if($category ->update($validatedData)) {
            return response()->json(['message' => 'Category updated successfully'],200);
        }

        return response()->json(['message' => 'some error happened'],500);
    }


    public function destroy(Category $category)
    {

        if(auth()->id() != $category -> user_id) {
            return response()->json(['message' => 'you do not have any access to delete this resource'],401);

        }

        if($category -> delete()) {
            return response()->json(['message' => 'Category deleted successfully'],200);
        }

        return response()->json(['message' => 'some error happened'],500);

    }

    public function deleted()
    {
        return Auth::user()->categories()->onlyTrashed()->get();
    }


    public function restore($categoryId) {
       $category = Category::withTrashed()->findOrFail($categoryId);


       if($category -> user_id != Auth()->id()) {
           return response()->json(['message' => 'you do not have any access to restore this resource'],401);

       }

       if($category -> forceDelete()) {
           return response()->json(['message' => 'Category restored successfully'],200);

       }

        return response()->json(['message' => 'some error happened'],500);

    }
    public function forceDelete($categoryId) {
        $category = Category::withTrashed()->findOrFail($categoryId);


        if($category -> user_id != Auth()->id()) {
            return response()->json(['message' => 'you do not have any access to restore this resource'],401);

        }

        if($category -> forceDelete()) {
            return response()->json(['message' => 'Category deleted successfully'],200);

        }

        return response()->json(['message' => 'some error happened'],500);
    }
}
