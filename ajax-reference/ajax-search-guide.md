# AJAX Search Implementation Guide (Real-time Search)

This comprehensive guide explains the complete AJAX search implementation used in this project. It includes instant search with debouncing, search filters, pagination integration, and URL state management.

---

## Project Files Reference

- **Controller**: [app/Http/Controllers/CourseController.php](app/Http/Controllers/CourseController.php)
- **Main View**: [resources/views/courses/index.blade.php](resources/views/courses/index.blade.php)
- **Partial View**: [resources/views/courses/partials/course_table.blade.php](resources/views/courses/partials/course_table.blade.php)
- **Helper Function**: [app/Helpers/helpers.php](app/Helpers/helpers.php)
- **Route**: [routes/web.php](routes/web.php)

---

## 1. Search Controller Method

The `search` method in `CourseController.php` handles all search requests:

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

### Method Breakdown:

#### Security Check
```php
if ($request->ajax())
```
- Verifies the request is made via AJAX (JavaScript)
- Prevents direct browser access to this endpoint
- Returns 400 error for non-AJAX requests

#### Input Retrieval
```php
$searchTerm = $request->input('search');
$searchBy = $request->input('search_by');
```
- `$searchTerm`: The search keyword entered by user (e.g., "PHP", "Laravel")
- `$searchBy`: Filter type - `'id'`, `'title'`, `'status'`, or `'all'`

#### Query Builder Initialization
```php
$query = Course::query();
```
- Creates a new Eloquent query builder instance
- Allows conditional query building

#### Conditional Search Logic
```php
if ($searchTerm) {
    if ($searchBy === 'title') {
        $query->where('title', 'LIKE', "%{$searchTerm}%");
    } elseif ($searchBy === 'id') {
        $query->where('id', 'LIKE', "%{$searchTerm}%");
    } elseif ($searchBy === 'status') {
        $query->where('status', 'LIKE', "%{$searchTerm}%");
    } else {
        // Search all fields
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'LIKE', "%{$searchTerm}%")
                ->orWhere('status', 'LIKE', "%{$searchTerm}%")
                ->orWhere('id', 'LIKE', "%{$searchTerm}%");
        });
    }
}
```

**Search Strategies:**
- **Single Field Search**: When `$searchBy` is specific (title/id/status)
- **Multi-Field Search**: When `$searchBy` is 'all', searches across all columns
- **LIKE Operator**: `%` wildcards enable partial matching (e.g., "PHP" matches "PHP Programming")

#### Pagination
```php
$courses = $query->paginate(10);
```
- Executes the query with pagination (10 items per page)
- Laravel automatically reads `page` parameter from request

#### JSON Response
```php
return response()->json([
    'html' => view('courses.partials.course_table', compact('courses', 'searchTerm'))->render(),
    'pagination' => (string) $courses->links(),
    'count' => $courses->total()
]);
```

**Response Structure:**
- `html`: Rendered HTML for table rows (partial view)
- `pagination`: Pagination links HTML string
- `count`: Total number of results found

---

## 2. Partial View for Table Rows

File: `resources/views/courses/partials/course_table.blade.php`

```blade
@foreach ($courses as $course)
    <tr>
        <td>{!! highlight($course->id, $searchTerm) !!}</td>
        <td>
            {!! highlight($course->title, $searchTerm) !!}
        </td>
        <td>
            {!! highlight($course->status, $searchTerm) !!}
        </td>
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
                <a href="{{ route('courses.destroy', $course->id) }}\" 
                   class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i> Delete
                </a>
            </div>
        </td>
    </tr>
@endforeach
```

### Key Points:

1. **Partial View Purpose**: Contains only table rows (no `<table>` wrapper)
2. **Highlight Function**: Uses `{!! !!}` to render HTML for highlighting search terms
3. **Dynamic Rendering**: Generated on server-side and returned as HTML string
4. **Action Buttons**: Full CRUD operations (View, Edit, Delete) remain functional

---

## 3. Search Form HTML

In `resources/views/courses/index.blade.php`:

```blade
<div class="card-header">
    <div class="row w-100">
        <!-- Add Course Button -->
        <div class="col-12 col-md-6 mb-2 mb-md-0">
            <a href="{{ route('courses.create') }}\" 
               class="btn btn-success btn-block btn-sm">
                <i class="fas fa-plus"></i> Add Course
            </a>
        </div>
        
        <!-- Search Filter Dropdown -->
        <div class="col-6 col-md-2 mt-2 mt-md-0">
            <select name="search_by" id="search_by" class="form-control">
                <option value="all">Search by all</option>
                <option value="id">ID</option>
                <option value="title">Title</option>
                <option value="status">Status</option>
            </select>
        </div>
        
        <!-- Search Input -->
        <div class="col-6 col-md-4 mt-2 mt-md-0">
            <input type="text" 
                   id="table_search" 
                   class="form-control" 
                   placeholder="Search" 
                   name="search">
        </div>
    </div>
</div>
```

---

## 4. JavaScript Implementation

### 4.1 Variables and Setup

```javascript
$(document).ready(function() {
    let debounceTimer;  // Timer for debouncing search input
    let ajaxRequest;    // Store current AJAX request for cancellation
```

### 4.2 Centralized Fetch Function

```javascript
function fetchResults(page = 1, pushState = true) {
    var search = $('#table_search').val().trim();
    var search_by = $('#search_by').val();

    // Cancel previous AJAX request if still running
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

            // Update browser URL without page reload
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
            // Ignore aborted requests
            if (status !== 'abort') {
                console.log('STATUS:', xhr.status);
                console.log('RESPONSE:', xhr.responseText);
            }
            $('#example1 tbody').css('opacity', '1');
        }
    });
}
```

**Function Parameters:**
- `page`: Page number to fetch (default: 1)
- `pushState`: Whether to update browser URL (default: true)

**Key Features:**
1. **Request Cancellation**: Aborts previous pending request
2. **GET Method**: Uses GET (not POST) for better caching and URL sharing
3. **Visual Feedback**: Table opacity changes during loading
4. **URL Management**: Updates browser address bar with current state
5. **Error Handling**: Gracefully handles errors except aborts

### 4.3 Search Input Handler (Debounced)

```javascript
$(document).on('input', '#table_search', function() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(function() {
        fetchResults(1, true);
    }, 500);
});
```

**Debouncing Explanation:**
- Waits 500ms after user stops typing before sending request
- Prevents excessive server requests during typing
- Improves performance and reduces server load
- Example: Typing "Laravel" sends only 1 request, not 7

### 4.4 Filter Change Handler

```javascript
$(document).on('change', '#search_by', function() {
    $('#table_search').trigger('input');
});
```

**Behavior**: When user changes filter dropdown, it triggers search immediately

### 4.5 Pagination Click Handler

```javascript
$(document).on('click', '#pagination_links .pagination a', function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
    var pageMatch = href.match(/page=(\\d+)/);
    var page = pageMatch ? pageMatch[1] : 1;
    fetchResults(page, true);
});
```

### 4.6 URL State Management

```javascript
// Initialize from URL parameters on page load
function handleUrlParams() {
    let urlParams = new URLSearchParams(window.location.search);
    let search = urlParams.get('search') || '';
    let search_by = urlParams.get('search_by') || 'all';
    let page = urlParams.get('page') || 1;

    if (search !== '' || search_by !== 'all' || page > 1) {
        $('#table_search').val(search);
        $('#search_by').val(search_by);
        fetchResults(page, false); // Don't push state again
    }
}

handleUrlParams();

// Handle browser back/forward buttons
window.onpopstate = function() {
    handleUrlParams();
};
```

**Benefits:**
- Direct URL access works (e.g., `/courses?search=PHP&page=2`)
- Browser back/forward buttons function correctly
- URLs can be shared with full search state

---

## 5. Route Configuration

In `routes/web.php`:

```php
Route::get('/search', [CourseController::class, 'search'])->name('courses.search');
```

**Important Notes:**
- Uses **GET method** (not POST)
- Named route: `courses.search`
- No CSRF token required for GET requests

---

## 6. Complete Search Flow

```
┌──────────────────────────────────────────────────────────────┐
│ User Types in Search Box                                    │
└────────────────────┬─────────────────────────────────────────┘
                     │
                     ▼
┌──────────────────────────────────────────────────────────────┐
│ input Event Triggered                                       │
│ - Clear existing debounce timer                             │
│ - Set new 500ms timer                                       │
└────────────────────┬─────────────────────────────────────────┘
                     │
                     ▼ (After 500ms of no typing)
┌──────────────────────────────────────────────────────────────┐
│ fetchResults(1, true) Called                                │
│ - Get search term and filter                                │
│ - Abort previous AJAX request if exists                     │
│ - Set table opacity to 0.5                                  │
└────────────────────┬─────────────────────────────────────────┘
                     │
                     ▼
┌──────────────────────────────────────────────────────────────┐
│ AJAX GET Request Sent                                       │
│ URL: /courses/search?search=PHP&search_by=all&page=1        │
└────────────────────┬─────────────────────────────────────────┘
                     │
                     ▼
┌──────────────────────────────────────────────────────────────┐
│ Controller: search() Method                                 │
│ - Verify AJAX request                                       │
│ - Build query with filters                                  │
│ - Paginate results (10 per page)                            │
│ - Render partial view                                       │
└────────────────────┬─────────────────────────────────────────┘
                     │
                     ▼
┌──────────────────────────────────────────────────────────────┐
│ JSON Response Returned                                      │
│ { html: "<tr>...</tr>", pagination: "<ul>...</ul>",        │
│   count: 42 }                                               │
└────────────────────┬─────────────────────────────────────────┘
                     │
                     ▼
┌──────────────────────────────────────────────────────────────┐
│ JavaScript Success Handler                                  │
│ - Replace table rows with data.html                         │
│ - Update pagination links                                   │
│ - Update result count badge                                 │
│ - Update browser URL (pushState)                            │
│ - Restore table opacity to 1                                │
└──────────────────────────────────────────────────────────────┘
```

---

## 7. Key Features Summary

### Performance Optimizations
- **Debouncing**: 500ms delay prevents excessive requests
- **Request Cancellation**: Aborts outdated AJAX calls
- **Partial Updates**: Only table content is replaced, not entire page

### User Experience
- **Instant Feedback**: Results appear as you type
- **Visual Loading**: Opacity change indicates processing
- **No Page Reload**: Smooth, seamless experience
- **Result Count**: Badge shows total matches

### Advanced Features
- **Multi-Field Search**: Search by ID, Title, Status, or All
- **Pagination Integration**: Search works seamlessly with pagination
- **URL State**: Shareable links with search state
- **Browser Navigation**: Back/forward buttons work correctly

---

## 8. Testing Scenarios

| Action | Expected Result |
|--------|----------------|
| Type "PHP" | Results filter after 500ms, showing only courses with "PHP" |
| Change filter to "Title" | Re-searches in title column only |
| Click page 2 | Shows page 2 with search term preserved |
| Copy URL and open in new tab | Shows same search results |
| Click browser back button | Returns to previous search state |
| Type rapidly | Only sends request after stopping for 500ms |
| Clear search box | Shows all courses |

---

## 9. Common Issues and Solutions

### Issue: Search doesn't work
**Solution:**
- Check route exists: `php artisan route:list | grep courses.search`
- Verify jQuery is loaded
- Check browser console for JavaScript errors
- Ensure controller method returns proper JSON

### Issue: Pagination breaks after search
**Solution:**
- Verify `fetchResults()` is called from pagination click handler
- Check that search term is passed in AJAX data
- Ensure pagination links have proper `data-page` attributes

### Issue: URL doesn't update
**Solution:**
- Verify `pushState` parameter is `true`
- Check browser supports HTML5 History API
- Ensure URL construction logic is correct

### Issue: Multiple requests sent rapidly
**Solution:**
- Verify debounce timer is working (check `clearTimeout`)
- Ensure request abortion is implemented
- Check delay value (should be 500ms)

---

## 10. Extension Ideas

1. **Advanced Filters**: Add date range, multi-select status
2. **Sort Options**: Add column sorting (ASC/DESC)
3. **Export Results**: Download filtered results as CSV/PDF
4. **Save Searches**: Allow users to save search queries
5. **Autocomplete**: Show suggestions as user types
6. **Keyboard Navigation**: Arrow keys for result navigation

---

## 11. Related Documentation

- [AJAX Pagination Guide](ajax-pagination-guide.md)
- [Highlighting Guide](highlighting-guide.md)
- [Main View File](../resources/views/courses/index.blade.php)
- [Controller File](../app/Http/Controllers/CourseController.php)
