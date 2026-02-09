# Search Term Highlighting Implementation Guide

This guide explains the complete implementation of search term highlighting in search results. When users search for a term, matching text is highlighted with a colored background for better visibility and user experience.

---

## 1. The Problem

When searching for "PHP", users get filtered results, but the search term blends with surrounding text:

```
ID    Title                      Status
1     PHP Programming Course     Active
15    Advanced PHP Development   Active
```

It's difficult to quickly identify why these results match the search query.

### The Solution

Highlight matching text with CSS styling:

```
ID    Title                               Status
1     [PHP] Programming Course            Active
15    Advanced [PHP] Development          Active
```

*(Where [PHP] represents highlighted text with yellow background)*

---

## 2. Helper Function Implementation

File: `app/Helpers/helpers.php`

```php
<?php

if (!function_exists('highlight')) {
    function highlight($text, $term, $className = 'bg-warning text-dark')
    {
        $text = (string) $text;
        $term = trim((string) ($term ?? ''));

        if ($term === '') {
            return e($text);
        }

        // Limit term length to avoid abuse
        $term = mb_substr($term, 0, 80);

        // Split into words (supports Arabic/English spaces)
        $parts = preg_split('/\s+/u', $term, -1, PREG_SPLIT_NO_EMPTY);

        if (empty($parts)) {
            return e($text);
        }

        // Escape original text once
        $escaped = e($text);

        // Build OR regex from tokens
        $escapedParts = array_map(fn($p) => preg_quote($p, '/'), $parts);
        $pattern = '/(' . implode('|', $escapedParts) . ')/iu';

        return preg_replace($pattern, '<span class="' . $className . '">$1</span>', $escaped);
    }
}
```

---

## 3. Function Breakdown

### 3.1 Function Declaration

```php
if (!function_exists('highlight')) {
    function highlight($text, $term, $className = 'bg-warning text-dark')
```

**Parameters:**
- `$text`: The original text to search within (e.g., "PHP Programming Course")
- `$term`: The search term to highlight (e.g., "PHP" or "PHP Programming")
- `$className`: CSS classes for highlighting (default: Bootstrap's yellow background)

**Why check if function exists?**
- Prevents "function already declared" errors
- Allows function to be safely included multiple times

---

### 3.2 Type Casting and Trimming

```php
$text = (string) $text;
$term = trim((string) ($term ?? ''));
```

**Purpose:**
- Ensures both parameters are strings (handles integers like IDs)
- Removes leading/trailing whitespace from search term
- `?? ''` provides empty string fallback for null values

---

### 3.3 Empty Term Check

```php
if ($term === '') {
    return e($text);
}
```

**Behavior:**
- If search term is empty, return escaped text without highlighting
- `e($text)` is Laravel's helper for `htmlspecialchars()` - prevents XSS attacks

---

### 3.4 Term Length Limitation

```php
$term = mb_substr($term, 0, 80);
```

**Security Feature:**
- Limits search term to 80 characters
- Prevents abuse with extremely long search strings
- `mb_substr()` handles multi-byte characters (e.g., Arabic, Chinese)

---

### 3.5 Multi-Word Support

```php
$parts = preg_split('/\s+/u', $term, -1, PREG_SPLIT_NO_EMPTY);

if (empty($parts)) {
    return e($text);
}
```

**Functionality:**
- Splits search term by whitespace (spaces, tabs, etc.)
- `/\s+/u`: Unicode-aware whitespace pattern
- `PREG_SPLIT_NO_EMPTY`: Removes empty results
- Example: "PHP Programming" → ["PHP", "Programming"]

**Result**: Each word is highlighted independently

---

### 3.6 Text Escaping

```php
$escaped = e($text);
```

**Critical Security Step:**
- Escapes HTML special characters before highlighting
- Prevents XSS injection attacks
- Must be done before adding `<span>` tags

**Example:**
```php
// Without escaping:
$text = "<script>alert('XSS')</script>";
// Would execute JavaScript!

// With escaping:
$text = "&lt;script&gt;alert('XSS')&lt;/script&gt;";
// Displays as text safely
```

---

### 3.7 Regex Pattern Building

```php
$escapedParts = array_map(fn($p) => preg_quote($p, '/'), $parts);
$pattern = '/(' . implode('|', $escapedParts) . ')/iu';
```

**Step-by-Step:**

1. **Escape special regex characters:**
   ```php
   preg_quote($p, '/')
   ```
   - Makes special characters literal (e.g., `C++` → `C\+\+`)
   - Second parameter `/` is the delimiter to escape

2. **Build OR pattern:**
   ```php
   implode('|', $escapedParts)
   ```
   - Joins words with `|` (OR operator)
   - Example: `PHP|Programming`

3. **Complete pattern:**
   ```php
   '/(PHP|Programming)/iu'
   ```
   - `()`: Capture group for replacement
   - `i`: Case-insensitive ("PHP" matches "php", "Php")
   - `u`: Unicode mode (supports international characters)

---

### 3.8 Replacement with Highlighting

```php
return preg_replace($pattern, '<span class="' . $className . '">$1</span>', $escaped);
```

**How it works:**
- `preg_replace()`: Replaces all pattern matches
- `$1`: Refers to captured group (the matched word)
- Wraps matched text in `<span>` with styling classes

**Example:**
```php
// Input:
$text = "PHP Programming Course";
$term = "PHP";

// Output:
"<span class='bg-warning text-dark'>PHP</span> Programming Course"
```

---

## 4. Usage in Blade Templates

File: `resources/views/courses/partials/course_table.blade.php`

```blade
@foreach ($courses as $course)
    <tr>
        <td>{!! highlight($course->id, $searchTerm) !!}</td>
        <td>{!! highlight($course->title, $searchTerm) !!}</td>
        <td>{!! highlight($course->status, $searchTerm) !!}</td>
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
```

### Important Points:

#### Use `{!! !!}` instead of `{{ }}`

```blade
{!! highlight($course->title, $searchTerm) !!}  ✅ Correct
{{ highlight($course->title, $searchTerm) }}    ❌ Wrong
```

**Why?**
- `{{ }}`: Escapes HTML (would show literal `<span>` tags)
- `{!! !!}`: Renders raw HTML (allows highlighting to display)
- Safe because `highlight()` already escapes the original text

---

## 5. CSS Styling

The default classes are Bootstrap 4/5 classes:

```css
.bg-warning {
    background-color: #ffc107; /* Yellow background */
}

.text-dark {
    color: #212529; /* Dark text for readability */
}
```

### Custom Styling Example

You can pass custom classes:

```blade
{!! highlight($course->title, $searchTerm, 'custom-highlight') !!}
```

Then define in your CSS:

```css
.custom-highlight {
    background-color: #ffeb3b;
    color: #000;
    font-weight: bold;
    padding: 2px 4px;
    border-radius: 3px;
}
```

---

## 6. Advanced Examples

### Example 1: Multi-Word Search

**Search term:** `"PHP Programming"`

**Input text:** `"Advanced PHP Programming Course"`

**Output:**
```html
Advanced <span class="bg-warning text-dark">PHP</span> 
<span class="bg-warning text-dark">Programming</span> Course
```

### Example 2: Case-Insensitive Matching

**Search term:** `"php"`

**Input text:** `"PHP programming course"`

**Output:**
```html
<span class="bg-warning text-dark">PHP</span> programming course
```

Notice: "PHP" (uppercase) is highlighted even though search was "php" (lowercase)

### Example 3: Special Characters

**Search term:** `"C++"`

**Input text:** `"Learn C++ Programming"`

**Output:**
```html
Learn <span class="bg-warning text-dark">C++</span> Programming
```

`preg_quote()` ensures `++` is treated literally, not as regex

---

## 7. Security Considerations

### XSS Protection

The function is XSS-safe because:

1. **Text is escaped first:**
   ```php
   $escaped = e($text);
   ```
   Converts `<script>` to `&lt;script&gt;`

2. **Highlighting is applied after escaping:**
   - Only safe `<span>` tags are added
   - User input cannot inject HTML

### Example Attack Prevention

**Malicious input:**
```php
$course->title = "<script>alert('XSS')</script>";
```

**After highlighting:**
```html
&lt;script&gt;alert('XSS')&lt;/script&gt;
```

**Result**: Displayed as text, not executed as JavaScript ✅

---

## 8. Performance Considerations

### Regex Efficiency

- Uses single `preg_replace()` call for all matches
- Efficient even with multiple words in search term

### Character Limit

```php
$term = mb_substr($term, 0, 80);
```

- Prevents ReDoS (Regular Expression Denial of Service) attacks
- Ensures reasonable processing time

---

## 9. Helper Registration

For the helper function to work globally, ensure it's loaded in `composer.json`:

```json
{
    "autoload": {
        "files": [
            "app/Helpers/helpers.php"
        ]
    }
}
```

Then run:
```bash
composer dump-autoload
```

---

## 10. Testing Examples

### Test 1: Basic Highlighting
```php
echo highlight('PHP Programming', 'PHP');
// Output: <span class="bg-warning text-dark">PHP</span> Programming
```

### Test 2: Empty Search Term
```php
echo highlight('PHP Programming', '');
// Output: PHP Programming (no highlighting)
```

### Test 3: Multi-Word Search
```php
echo highlight('Learn PHP and Laravel Framework', 'PHP Laravel');
// Output: Learn <span>PHP</span> and <span>Laravel</span> Framework
```

### Test 4: XSS Protection
```php
echo highlight('<script>alert(1)</script>', 'script');
// Output: &lt;<span>script</span>&gt;alert(1)&lt;/<span>script</span>&gt;
```

---

## 11. Comparison: Old vs New Implementation

| Feature | Old Version | New Version |
|---------|-------------|-------------|
| Multi-word search | ❌ No | ✅ Yes |
| Custom CSS classes | ❌ No | ✅ Yes (parameter) |
| Unicode support | ⚠️ Limited | ✅ Full (`/u` flag) |
| Character limit | ❌ No | ✅ 80 chars max |
| Type safety | ⚠️ Assumed strings | ✅ Explicit casting |
| Word splitting | ❌ Single term only | ✅ Handles multiple words |

---

## 12. Troubleshooting

### Issue: Highlighting doesn't appear

**Check:**
1. Using `{!! !!}` not `{{ }}` in Blade
2. Bootstrap CSS is loaded for `bg-warning` class
3. Search term is being passed to partial view

### Issue: HTML tags visible in output

**Cause**: Using `{{ }}` instead of `{!! !!}`

**Solution**: Change to `{!! highlight(...) !!}`

### Issue: Special characters break highlighting

**Cause**: Not using `preg_quote()`

**Solution**: Already implemented in current version

### Issue: Performance lag with long text

**Cause**: No character limit

**Solution**: Already implemented (80 char limit)

---

## 13. Future Enhancements

1. **Configurable character limit**: Move to config file
2. **Multiple highlight colors**: Different colors for different search terms
3. **Smart highlighting**: Avoid highlighting inside HTML attributes
4. **Stemming support**: Highlight word variations (e.g., "program", "programming")
5. **Proximity highlighting**: Highlight entire phrases when words are close together
        </td>
        <td>
            {!! highlight($course->status, $searchTerm) !!}
        </td>
        <td>
            <div class="btn-group-responsive">
                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i>
                    View</a>
                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning"><i
                        class="fas fa-pencil-alt"></i> Edit</a>
                <a href="{{ route('courses.destroy', $course->id) }}" class="btn btn-sm btn-danger"><i
                        class="fas fa-trash"></i> Delete</a>
            </div>
        </td>
    </tr>
@endforeach
```