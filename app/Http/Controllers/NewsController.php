<?php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class NewsController extends Controller
{
 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
    $perPage = 5;
    $offset = (int) $request->input('offset', 0);

    // Build the base query (you can add role-based filtering later if needed)
    $query = News::latest();

    // Get total count for "load more" functionality
    $totalCount = $query->count();

    // Fetch current chunk
    $news = $query->skip($offset)->take($perPage)->get();

    if ($request->ajax()) {
        $html = view('News.newsCards', compact('news'))->render();

        return response()->json([
            'html' => $html,
            'count' => $news->count(),
            'total' => $totalCount
        ]);
    }

    // Initial load with first set + total count
    return view('News.index', compact('news', 'totalCount'));
}



    //for users
    public function viewNews(Request $request){
            $perPage = 5;
            $offset = $request->input('offset', 0);
            $user = Auth::user();
            $roles = $user->getRoleNames();
            
            // Build the base query with role-based filtering
            $query = News::where(function($query) use ($roles) {
                foreach ($roles as $role) {
                    $query->orWhereJsonContains('category', $role);
                }
                $query->orWhereJsonContains('category', 'All');
            })
            ->latest();

            // Get the total count of filtered announcements
            // Get the announcements for the current page
            $news = $query->skip($offset)->take($perPage)->get();

            // If AJAX request, return only announcements HTML
            if ($request->ajax()) {
                $html = view('News.newsCardsForUsers', compact('news'))->render();

                return response()->json([
                    'html' => $html,
                    'count' => $news->count()
                ]);
            }
     
      return view('News.viewNews', compact('news'));
    }

/*
public function viewNewsForPublic(Request $request)
{
    $perPage = 4;
    $offset = $request->input('offset', 0);

    $query = News::latest();

    // Title filter
    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    // Date filter
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Category filter (array field)
    if ($request->filled('category')) {
        $category = $request->category;
        $query->whereJsonContains('category', $category);
    }

    // Pagination
    $news = $query->skip($offset)->take($perPage)->get();

    // Latest news links
    $latestNews = News::latest()->take(5)->get();

    // All categories from news (flatten array)
    $allCategories = News::pluck('category')
                         ->flatten()
                         ->unique()
                         ->values();

    if ($request->ajax()) {
        $html = view('components.news-cards', compact('news'))->render();
        return response()->json([
            'html'  => $html,
            'count' => $news->count()
        ]);
    }

    return view('News.news', compact('news', 'latestNews', 'allCategories'));
}

*/


public function viewNewsForPublic(Request $request)
{
    $perPage = 6;

    $query = News::latest();

    // Filter by title
    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    // Filter by category
    if ($request->filled('category')) {
        $query->whereJsonContains('category', $request->category);
    }

    // Filter by month (YYYY-MM)
    if ($request->filled('date')) {
        $query->whereYear('created_at', substr($request->date, 0, 4))
              ->whereMonth('created_at', substr($request->date, 5, 2));
    }

    // ALWAYS paginate
    $news = $query->paginate($perPage)->withQueryString();

    // For sidebar (latest 5)
    $latestNews = News::latest()->take(5)->get();

    // All category list
    $allCategories = News::pluck('category')
                        ->flatten()
                        ->unique()
                        ->values();

    // AJAX request → return only the HTML for cards + pagination
    if ($request->ajax()) {
        return response()->json([
            'html'       => view('components.news-cards', compact('news'))->render(),
            'pagination' => view('components.pagination', ['news' => $news])->render(),
        ]);
    }

    return view('News.news2', compact('news', 'latestNews', 'allCategories'));
}


//for details view
public function show($id)
{
    $news = News::findOrFail($id);
    return view('news.show', compact('news'));
}


    /**
     * Show the form for creating a new resource.
     */
   public function create()
        {
            $user = Auth::user();
            $roles = Role::pluck('name'); // Get all role names in the system

            return view('News.create', compact('roles', 'user'));
        }

    /**
     * Store a newly created resource in storage.
     */



public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'message' => 'required|string',
        'category' => 'required|array',        // array of categories
        'category.*' => 'string',              // each item should be a string
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $imagePaths = [];
    if ($request->hasFile('images')) {
        $destinationPath = public_path('uploads/news');

        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        foreach ($request->file('images') as $image) {
            $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $filename);
            $imagePaths[] = 'uploads/news/' . $filename;
        }
    }

    News::create([
        'title'     => $validatedData['title'],
        'message'   => $validatedData['message'],
        'category'  => $validatedData['category'], // **no json_encode** needed
        'images'    => $imagePaths,
        'postDate'  => now(),
        'posted_by' => Auth::user()->username,
    ]);

    return redirect()->route('news.index')
                     ->with('success', 'News created successfully!');
}



    /**
     * Show the form for editing the specified resource.
     */

public function edit(News $news)
{
    // Get all roles
    $roles = Role::pluck('name'); // returns a collection of all role names

    return view('News.edit', compact('news', 'roles'));
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, News $news)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'message' => 'required|string',
        'category' => 'required|array', // it's now an array of roles
        'category.*' => 'string',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'remove_images' => 'nullable|array', // for deleted existing images
        'remove_images.*' => 'string',
    ]);

    $currentImages = $news->images ?? [];

    // Remove deleted images
    if ($request->filled('remove_images')) {
        foreach ($request->remove_images as $img) {
            if (($key = array_search($img, $currentImages)) !== false) {
                unset($currentImages[$key]);
                if (File::exists(public_path($img))) {
                    File::delete(public_path($img));
                }
            }
        }
        $currentImages = array_values($currentImages); // reindex array
    }

    // Handle new uploaded images
    if ($request->hasFile('images')) {
        $destinationPath = public_path('uploads/news');
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        foreach ($request->file('images') as $image) {
            $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $filename);
            $currentImages[] = 'uploads/news/' . $filename;
        }
    }

    // Update announcement
    $news->update([
        'title' => $validatedData['title'],
        'message' => $validatedData['message'],
        'category' => $validatedData['category'], // array of roles
        'images' => $currentImages,
    ]);

    return redirect()->back()->with('success', 'News updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
public function destroy(News $news)
{
    // Delete images from storage
    if (!empty($news->images)) {
        foreach ($news->images as $image) {
            if (File::exists(public_path($image))) {
                File::delete(public_path($image));
            }
        }
    }

    $news->delete();

    return response()->json([
        'success' => true, // ✅ match JS check
        'message' => 'News deleted successfully!',
        'id'      => $news->id
    ]);
}


}
