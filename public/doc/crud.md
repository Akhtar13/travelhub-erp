# Admin CRUD Pattern Guide

How to build a standard admin CRUD module in this project. The pattern is consistent across **Region**, **Location**, **Branch**, **Depot**, **Nationality**, etc.

**Example module used below:** `Location` (simple CRUD with image upload and delete guard).

**URL prefix:** All admin routes live under `/admin` with route names prefixed `admin.` (see `RouteServiceProvider`).

---

## File Structure (one CRUD module)

Using `location` as the module name:

```
app/
├── Http/
│   ├── Controllers/Admin/
│   │   └── LocationController.php      # index, create, store, edit, destroy, getDatatable, changeStatus
│   └── Requests/Admin/
│       └── LocationStoreRequest.php      # validation for create + update (single store method)
├── Models/
│   └── Location.php                      # Eloquent model (often minimal)
└── Helpers/
    ├── AdminDataTableButtonHelper.php    # shared — action dropdown HTML
    └── AdminDataTableBadgeHelper.php     # shared — status badge HTML

resources/
├── views/admin/location/
│   ├── index.blade.php                   # list + DataTable
│   ├── create.blade.php                  # add form
│   └── edit.blade.php                    # edit form (same fields, edit_value = id)
└── lang/
    ├── en/messages.php                   # translation keys
    └── ar/messages.php                   # Arabic translations

routes/
└── admin.php                             # Route::resource + getDatatable + changeStatus

public/assets/custom-js/
├── custom/
│   ├── datatable.js                      # shared — list AJAX, delete, status toggle
│   └── form.js                           # shared — create/edit form submit via Axios
└── admin/
    └── location.js                       # optional — only if module needs extra JS (most CRUDs skip this)
```

> **Booking**, **Agent**, **Route**, and **Consignment** follow the same base pattern but add module-specific JS under `public/assets/custom-js/admin/`.

---

## Request Flow

### List (index)

```
Browser  GET  /admin/location
    → LocationController@index
    → view('admin.location.index')

Browser  GET  /admin/get-location  (AJAX, server-side DataTables)
    → LocationController@getDatatable
    → Yajra DataTables JSON
    → datatable.js renders table
```

### Create

```
Browser  GET  /admin/location/create
    → LocationController@create
    → view('admin.location.create')

Browser  POST  /admin/location  (edit_value = 0)
    → LocationStoreRequest validates
    → LocationController@store  → creates record
    → JSON { message: "..." }
    → form.js shows toast + redirects to /admin/location
```

### Edit

```
Browser  GET  /admin/location/{id}/edit
    → LocationController@edit
    → view('admin.location.edit', compact('location'))

Browser  POST  /admin/location  (edit_value = {id})
    → LocationStoreRequest validates
    → LocationController@store  → updates record
    → JSON + redirect
```

### Delete

```
Browser  DELETE  /admin/location/{id}
    → LocationController@destroy
    → JSON { message: "..." }
    → datatable.js refreshes table
```

### Status toggle (click badge in list)

```
Browser  GET  /admin/location/status/{id}/{status}
    → LocationController@changeStatus
    → JSON + table refresh
```

---

## Step-by-Step: Add a New CRUD Module

Replace `Product` / `product` / `products` with your module name.

### 1. Model

```php
// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;   // most legacy tables have no timestamps
    protected $guarded = [];
}
```

### 2. Form Request

```php
// app/Http/Requests/Admin/ProductStoreRequest.php
namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'edit_value' => 'required',
            'name'       => 'required',
            'ar_name'    => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors()->first()
        ], 422));
    }
}
```

> Validation always returns **JSON 422** with a single `message` — the frontend shows it via `notificationToast()`.

### 3. Controller

```php
// app/Http/Controllers/Admin/ProductController.php
namespace App\Http\Controllers\Admin;

use App\Helpers\AdminDataTableBadgeHelper;
use App\Helpers\AdminDataTableButtonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index');
    }

    public function getDatatable(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::select('products.*', \DB::raw('
                CASE WHEN "' . App::getLocale() . '" = "en" THEN name ELSE ar_name END as name
            '));

            return Datatables::of($query)
                ->addColumn('action', function ($row) {
                    return AdminDataTableButtonHelper::actionButtonDropdown2([
                        'id' => $row->id,
                        'actions' => [
                            'edit'   => route('admin.product.edit', [$row->id]),
                            'delete' => '',
                        ],
                    ]);
                })
                ->addColumn('status', fn ($row) => AdminDataTableBadgeHelper::statusBadge($row))
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        if ((int) $request['edit_value'] === 0) {
            $product = new Product();
            $product->name    = $request['name'];
            $product->ar_name = $request['ar_name'];
            $product->save();

            return response()->json(['message' => trans('messages.product_added_successfully')]);
        }

        $product = Product::find($request['edit_value']);
        $product->name    = $request['name'];
        $product->ar_name = $request['ar_name'];
        $product->save();

        return response()->json(['message' => trans('messages.product_updated_successfully')]);
    }

    public function edit($id)
    {
        return view('admin.product.edit', ['product' => Product::findOrFail($id)]);
    }

    public function destroy($id): JsonResponse
    {
        Product::where('id', $id)->delete();
        return response()->json(['message' => trans('messages.product_delete_successfully')]);
    }

    public function changeStatus($id, $status): JsonResponse
    {
        Product::where('id', $id)->update(['status' => $status]);
        return response()->json(['message' => trans('messages.status_change_success')]);
    }
}
```

**Key conventions in `store()`:**

| Pattern | Meaning |
|---------|---------|
| `edit_value === 0` | Create |
| `edit_value === {id}` | Update (same `store` method, not `update`) |
| `return response()->json(['message' => ...])` | All writes return JSON |
| `trans('messages.xxx')` | User-facing strings from lang files |
| `CacheHelper::clearCacheByKey(...)` | Call after mutations if module is cached |

### 4. Routes (`routes/admin.php`)

Inside the authenticated middleware group:

```php
use App\Http\Controllers\Admin\ProductController;

// Resource routes: index, create, store, edit, update, destroy
Route::resource('product', ProductController::class);

// DataTable AJAX endpoint (naming: get-{module})
Route::get('/get-product', [ProductController::class, 'getDatatable'])->name('get-product');

// Status toggle (naming: /{module}/status/{id}/{status})
Route::get('/product/status/{id}/{status}', [ProductController::class, 'changeStatus'])
    ->name('change-status-product');
```

**Generated URLs:**

| Action | Method | URL | Route name |
|--------|--------|-----|------------|
| List | GET | `/admin/product` | `admin.product.index` |
| Create form | GET | `/admin/product/create` | `admin.product.create` |
| Store/Update | POST | `/admin/product` | `admin.product.store` |
| Edit form | GET | `/admin/product/{id}/edit` | `admin.product.edit` |
| Delete | DELETE | `/admin/product/{id}` | `admin.product.destroy` |
| DataTable | GET | `/admin/get-product` | `admin.get-product` |
| Status | GET | `/admin/product/status/{id}/{status}` | `admin.change-status-product` |

> `update` from `Route::resource` is registered but **not used** — create and edit both POST to `store`.

### 5. Views

#### `index.blade.php`

```blade
@extends('admin.layouts.master')
@section('content')
    {{-- page title + card header with "Add New" button --}}
    <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm">
        {{ trans('messages.add_new') }}
    </a>

    <table class="table table-bordered dt-responsive nowrap table-striped align-middle"
           id="basic-1" style="width:100%">
        <thead>
        <tr>
            <th>{{ trans('messages.id') }}</th>
            <th>{{ trans('messages.name') }}</th>
            <th>{{ trans('messages.status') }}</th>
            <th>{{ trans('messages.action') }}</th>
        </tr>
        </thead>
    </table>
@endsection

@section('custom-script')
    <script>
        let datatable_url = '/get-product'
        let redirect_url = '/product'
        let form_url = '/product'
        const sweetalert_delete_title = '{{ trans('messages.product_delete_title') }}'
        const sweetalert_delete_text  = '{{ trans('messages.product_delete_text') }}'

        $.extend(true, $.fn.dataTable.defaults, {
            columns: [
                { data: 'id',     name: 'products.id' },
                { data: 'name',   name: 'products.name' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            order: [0, 'desc']
        })
    </script>
    <script src="{{ asset('assets/custom-js/custom/datatable.js') }}?v={{ time() }}"></script>
@endsection
```

**Required JS variables for index:**

| Variable | Purpose |
|----------|---------|
| `datatable_url` | GET endpoint for DataTables |
| `form_url` | Base path for DELETE (`form_url + '/' + id`) and status (`form_url + '/status/' + id + '/' + status`) |
| `redirect_url` | Not used on index (used on forms) |
| `sweetalert_delete_*` | Confirm dialog text for delete |

Table element **must** have `id="basic-1"` — `datatable.js` targets `#basic-1`.

#### `create.blade.php` / `edit.blade.php`

```blade
@extends('admin.layouts.master')
@section('content')
    <form method="POST" id="addEditForm" role="form">
        @csrf
        {{-- create: edit_value = 0 --}}
        <input type="hidden" id="edit_value" value="0" name="edit_value">
        {{-- edit: edit_value = {{ $product->id }} and pre-fill inputs with {{ $product->name }} --}}

        {{-- form fields in row mb-3 layout (label col-lg-3, input col-lg-9) --}}

        <button type="submit" class="btn btn-success btn-sm">{{ trans('messages.save') }}</button>
        <a href="{{ route('admin.product.index') }}" class="btn btn-danger btn-sm">{{ trans('messages.cancel') }}</a>
    </form>
@endsection

@section('custom-script')
    <script>
        let form_url = '/product'
        let redirect_url = '/product'
    </script>
    <script src="{{ asset('assets/custom-js/custom/form.js') }}"></script>
@endsection
```

**Required JS variables for forms:**

| Variable | Purpose |
|----------|---------|
| `form_url` | POST target: `APP_URL + form_url` |
| `redirect_url` | Redirect after success |

Form **must** have `id="addEditForm"` — `form.js` binds to it.

### 6. Translations

Add keys to both `resources/lang/en/messages.php` and `resources/lang/ar/messages.php`:

```php
'products' => 'Products',
'product_list' => 'Product List',
'product_added_successfully' => 'Product added successfully',
'product_updated_successfully' => 'Product updated successfully',
'product_delete_successfully' => 'Product deleted successfully',
'product_delete_title' => 'Delete Product?',
'product_delete_text' => 'This action cannot be undone.',
'sidebar_product' => 'Products',
```

Use `trans('messages.key')` in Blade and `trans('messages.key')` in controllers.

### 7. Sidebar menu

`resources/views/admin/layouts/sidebar.blade.php`:

```blade
<a class="nav-link menu-link {{ (request()->segment(2) === 'product') ? 'active' : '' }}"
   href="{{ route('admin.product.index') }}">
    <span>{{ trans('messages.sidebar_product') }}</span>
</a>
```

`request()->segment(2)` is the module slug after `/admin/`.

---

## Shared Frontend Layer

### `form.js` — create/edit submit

- Intercepts `#addEditForm` submit
- POSTs `FormData` via **Axios** to `APP_URL + form_url`
- On success: toast + redirect to `APP_URL + redirect_url` after 1s
- On error (422): shows `error.response.data.message`

### `datatable.js` — list page

- Initializes **server-side** DataTable on `#basic-1`
- **Delete:** `.delete-single` → `DELETE form_url/{id}` (SweetAlert confirm)
- **Status:** `.status-change` on badge → `GET form_url/status/{id}/{status}`
- **View modal:** `.detail-button` → `GET modal_url/{id}` (modules that define `modal_url`)
- Supports optional filters via `$('#status').val()` etc.

### `master.blade.php` layout

- Sets `APP_URL` in scripts (from `admin.layouts.script`)
- Includes CSRF meta tag
- RTL when `auth()->guard('admin')->user()->locale == 'ar'`
- Global `#detailsModal` for view-in-modal pattern

---

## DataTable Action Buttons

Pass an array to `AdminDataTableButtonHelper::actionButtonDropdown2()`:

```php
[
    'id' => $row->id,
    'actions' => [
        'edit'   => route('admin.product.edit', [$row->id]),  // link
        'view'   => $row->id,                                  // opens modal via JS
        'view_page' => route('admin.product.show', [$row->id]), // full page
        'delete' => '',                                          // enables delete button
        'print'  => '',                                          // print handler
        'invoice'=> '',                                          // download handler
        'add_credit' => '',                                      // agent credit modal
        'additional_config' => route('...'),                     // route extra config
    ],
]
```

Status column uses `AdminDataTableBadgeHelper::statusBadge($row)` — clickable badge triggers `.status-change` in `datatable.js`.

**Status values in DB:** `active` / `inActive` or `Active` / `InActive` (both handled in badge helper).

---

## Variations

### Image / file upload (Location pattern)

In `store()`:

```php
if ($request->hasFile('location_qr')) {
    $upload_result = ImageUploadHelper::uploadImageSpace($request->location_qr, 'location-qr', [
        'digitalocean' => 'location_qr',
        'contabo'      => 'secondary_location_qr',
    ]);
    $model->{$upload_result['column']} = $upload_result['value'];
}
```

Form must use `enctype="multipart/form-data"` (or let `FormData` handle it — `form.js` already uses `FormData`).

### Dropdown data on create/edit

```php
public function create()
{
    $regions = CacheHelper::region();
    return view('admin.product.create', compact('regions'));
}
```

Use `CacheHelper` for regions, locations, routes — not raw DB queries in views.

### Delete with dependency check (Location pattern)

```php
public function destroy($id): JsonResponse
{
    if (Route::where('start_point_id', $id)->exists()) {
        return response()->json(['message' => trans('messages.in_use')], 422);
    }
    Location::where('id', $id)->delete();
    return response()->json(['message' => trans('messages.deleted')]);
}
```

### Create + update in one `store` — no separate `update` method

This is the **standard pattern** across the project. Laravel's `Route::resource` registers `update`, but controllers use only `store` with `edit_value`.

### Complex CRUD (Agent, Booking, Route)

Same file layout, but additionally:

| Extra | Where |
|-------|--------|
| Custom JS | `public/assets/custom-js/admin/{module}.js` |
| Multiple AJAX endpoints | Extra routes in `admin.php` (not only `get-{module}`) |
| DB transactions | `DB::beginTransaction()` / `commit()` / `rollBack()` in `store` |
| Nested child records | e.g. Agent creates `agent_routes` + `agent_seats` in same `store` |

### Region — dynamic schema on create

`RegionController@store` runs raw `ALTER TABLE` when a new region is added (adds `region_{id}_charge` columns to `routes`, `route_charges`, `bookings`, `agent_routes`). This is **exceptional** — normal CRUDs do not alter schema.

---

## Middleware & Auth

All CRUD routes in `admin.php` sit inside:

```php
Route::group(['middleware' => ['auth:admin,branchManager,salesPerson', 'adminCheck', 'adminLanguage']], function () {
    // resources here
});
```

- Login uses `users` table with `user_type` filter per guard
- Not all user types see all sidebar items (check `sidebar.blade.php` conditions)

---

## Checklist: New CRUD Module

```
[ ] Database table exists (or migration added)
[ ] app/Models/{Model}.php
[ ] app/Http/Requests/Admin/{Model}StoreRequest.php
[ ] app/Http/Controllers/Admin/{Model}Controller.php
      - index, getDatatable, create, store, edit, destroy, changeStatus
[ ] resources/views/admin/{module}/index.blade.php
[ ] resources/views/admin/{module}/create.blade.php
[ ] resources/views/admin/{module}/edit.blade.php
[ ] routes/admin.php — resource + get-{module} + status route
[ ] resources/lang/en/messages.php — keys
[ ] resources/lang/ar/messages.php — keys
[ ] resources/views/admin/layouts/sidebar.blade.php — menu link
[ ] CacheHelper::clearCacheByKey() if data is cached
[ ] Optional: module-specific JS in public/assets/custom-js/admin/
```

---

## Quick Reference: Location Module (real files)

| Layer | Path |
|-------|------|
| Controller | `app/Http/Controllers/Admin/LocationController.php` |
| Request | `app/Http/Requests/Admin/LocationStoreRequest.php` |
| Model | `app/Models/Location.php` |
| Views | `resources/views/admin/location/` |
| Routes | `Route::resource('location', ...)` + `/get-location` + `/location/status/{id}/{status}` |
| Shared JS | `public/assets/custom-js/custom/datatable.js`, `form.js` |

---

*See also: [PROJECT_OVERVIEW.md](PROJECT_OVERVIEW.md) for business domain and database tables.*
