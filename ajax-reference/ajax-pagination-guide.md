# AJAX Pagination Implementation Guide

This guide explains the complete implementation of dynamic AJAX pagination in Laravel, allowing users to navigate between pages without full page reload. The implementation includes advanced features like debouncing, request cancellation, and URL state management.

---

## 1. Overview

The pagination system uses jQuery AJAX to fetch paginated results dynamically. Key features include:
- **No page reload**: Smooth navigation between pages
- **Search integration**: Pagination works seamlessly with search filters
- **URL state management**: Browser back/forward buttons work correctly
- **Request optimization**: Automatic cancellation of pending requests
- **Visual feedback**: Opacity changes during data loading

---

## 2. HTML Structure

In `resources/views/courses/index.blade.php`, pagination links are rendered inside a dedicated container:

```blade
<div class="card-footer clearfix" id="pagination_links">
    {{ $courses->links() }}
</div>
```

**Why `id="pagination_links"`?**
- This ID is targeted by jQuery to dynamically update pagination links after AJAX requests
- Laravel's `$courses->links()` generates Bootstrap-compatible pagination HTML

### Initial Table Structure

```blade
<table id="example1" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Course Title</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->title }}</td>
                <td>{{ $course->status }}</td>
                <td>
                    <div class="btn-group-responsive">
                        <a href="{{ route('courses.show', $course->id) }}" 
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('courses.edit', $course->id) }}" 
                           class="btn btn-sm btn-warning">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>
                        <a href="{{ route('courses.destroy', $course->id) }}" 
                           class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
```

---

## 3. JavaScript Implementation

The pagination handling is implemented in the `@section('scripts')` block:

### 3.1 Pagination Click Handler

```javascript
$(document).on('click', '#pagination_links .pagination a', function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
    var pageMatch = href.match(/page=(\d+)/);
    var page = pageMatch ? pageMatch[1] : 1;
    fetchResults(page, true);
});
```

**Explanation:**
- `e.preventDefault()`: Prevents default link navigation
- `href.match(/page=(\d+)/)`: Extracts page number from URL using regex
- `pageMatch ? pageMatch[1] : 1`: Defaults to page 1 if no match found
- `fetchResults(page, true)`: Calls centralized fetch function with URL state update

### 3.2 Centralized Fetch Function

All AJAX requests (pagination, search, filter changes) use this unified function:

```javascript
let ajaxRequest; // Store current AJAX request for cancellation

function fetchResults(page = 1, pushState = true) {
    var search = $('#table_search').val().trim();
    var search_by = $('#search_by').val();

    // Cancel previous request if still running
    if (ajaxRequest) {
        ajaxRequest.abort();
    }

    // Visual loading indicator
    $('#example1 tbody').css('opacity', '0.5');

    ajaxRequest = $.ajax({
        url: "{{ route('courses.search') }}",
        method: 'get',
        dataType: 'json',
        data: {
            search_by: search_by,
            search: search,
            page: page
        },
        success: function(data) {
            // Update table content
            $('#example1 tbody').html(data.html);
            $('#course_count').text('(' + data.count + ')');
            $('#pagination_links').html(data.pagination);
            $('#example1 tbody').css('opacity', '1');

            // Update browser URL (if pushState is true)
            if (pushState) {
                let url = new URL(window.location.href);

                if (search) {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }

                if (search_by !== 'all') {
                    url.searchParams.set('search_by', search_by);
                } else {
                    url.searchParams.delete('search_by');
                }

                if (page > 1) {
                    url.searchParams.set('page', page);
                } else {
                    url.searchParams.delete('page');
                }

                window.history.pushState({}, '', url);
            }
        },
        error: function(xhr, status) {
            if (status !== 'abort') {
                console.log('STATUS:', xhr.status);
                console.log('RESPONSE:', xhr.responseText);
            }
            $('#example1 tbody').css('opacity', '1');
        }
    });
}
```

**Key Features:**

1. **Request Cancellation**: If user clicks pagination rapidly, previous requests are aborted
2. **GET Method**: Uses GET instead of POST for better caching and URL shareability
3. **URL State Management**: Updates browser URL without page reload
4. **Visual Feedback**: Reduces table opacity during loading
5. **Error Handling**: Ignores abort errors, logs other errors

---

## 4. URL State Management

### 4.1 Initialize from URL Parameters

When the page loads, read URL parameters and fetch corresponding data:

```javascript
function handleUrlParams() {
    let urlParams = new URLSearchParams(window.location.search);
    let search = urlParams.get('search') || '';
    let search_by = urlParams.get('search_by') || 'all';
    let page = urlParams.get('page') || 1;

    if (search !== '' || search_by !== 'all' || page > 1) {
        $('#table_search').val(search);
        $('#search_by').val(search_by);
        fetchResults(page, false); // false = don't push state again
    }
}

handleUrlParams();
```

### 4.2 Handle Browser Back/Forward Buttons

```javascript
window.onpopstate = function() {
    handleUrlParams();
};
```

**Result**: Users can navigate using browser back/forward buttons and the correct data is fetched.

---

## 5. Backend Controller Method

The `search` method in `CourseController.php` handles pagination:

```php
public function search(Request $request)
{
    if ($request->ajax()) {
        $searchTerm = $request->input('search');
        $searchBy = $request->input('search_by');

        $query = Course::query();

        if ($searchTerm) {
            if ($searchBy === 'title') {
                $query->where('title', 'LIKE', "%{$searchTerm}%");
            } elseif ($searchBy === 'id') {
                $query->where('id', 'LIKE', "%{$searchTerm}%");
            } elseif ($searchBy === 'status') {
                $query->where('status', 'LIKE', "%{$searchTerm}%");
            } else {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('status', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('id', 'LIKE', "%{$searchTerm}%");
                });
            }
        }

        $courses = $query->paginate(10);

        return response()->json([
            'html' => view('courses.partials.course_table', compact('courses', 'searchTerm'))->render(),
            'pagination' => (string) $courses->links(),
            'count' => $courses->total()
        ]);
    }

    return response()->json(['error' => 'Invalid request'], 400);
}
```

**Important**: Laravel's `paginate()` automatically reads the `page` parameter from the request.

---

## 6. Route Configuration

In `routes/web.php`:

```php
Route::get('/search', [CourseController::class, 'search'])->name('courses.search');
```

**Note**: Using GET method (not POST) for better URL handling and caching.

---

## 7. Complete Flow Diagram

```
1. User clicks pagination link (e.g., page 2)
   ↓
2. JavaScript prevents default action
   ↓
3. Extract page number from href
   ↓
4. Call fetchResults(2, true)
   ↓
5. Abort any pending AJAX request
   ↓
6. Send GET request to /courses/search?page=2
   ↓
7. Controller queries database with pagination
   ↓
8. Return JSON: {html, pagination, count}
   ↓
9. Update table tbody, pagination links, and count
   ↓
10. Update browser URL with pushState
   ↓
11. Restore table opacity
```

---

## 8. Benefits of This Approach

1. **User Experience**: No full page reload, instant navigation
2. **Performance**: Only table data is transferred, not entire page
3. **URL Sharing**: Users can share direct links to specific pages/searches
4. **Browser History**: Back/forward buttons work as expected
5. **Request Efficiency**: Automatic cancellation prevents race conditions
6. **Maintainability**: Centralized `fetchResults()` function reduces code duplication

---

## 9. Testing Checklist

- [ ] Click pagination links - table updates without reload
- [ ] Search term is preserved when changing pages
- [ ] Filter (search_by) is preserved when changing pages
- [ ] URL updates with correct parameters
- [ ] Browser back button loads previous page
- [ ] Browser forward button works correctly
- [ ] Rapid clicking doesn't cause multiple requests
- [ ] Direct URL access works (e.g., /courses?page=3&search=php)

---

## 10. Troubleshooting

**Issue**: Pagination links don't work
- Check route is defined: `php artisan route:list | grep courses.search`
- Verify `#pagination_links` ID exists in HTML
- Check browser console for JavaScript errors

**Issue**: URL doesn't update
- Ensure `pushState` parameter is `true` in `fetchResults()`
- Check browser supports HTML5 History API

**Issue**: Back button doesn't work
- Verify `window.onpopstate` handler is registered
- Ensure `handleUrlParams()` reads URL correctly

---

## 11. Related Documentation

- [AJAX Search Guide](ajax-search-guide.md)
- [Highlighting Guide](highlighting-guide.md)
- [Main View File](../resources/views/courses/index.blade.php)
- [Controller File](../app/Http/Controllers/CourseController.php)
