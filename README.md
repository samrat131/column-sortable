
# Laravel Column Sortable

Sort laravel model view list by database column or field wise

## Installation

To use this package in your project, please use Composer to add the package to your laravel applications

```
composer require samrat131/column-sortable
```

Edit `config/app.php` file and add following lines (only for laravel version below 5.5)

```
'providers' => [
	...
	Samrat131\ColumnSortable\ColumnSortableServiceProvider::class,
]
```

## Usage

### Model

Edit any laravel model .php file, add `SortableTrait` shipped with this package,
add `protected $columnToSort` variable and list database field/cloumn that needs to be sortable.

```
<?php

namespace App;

use Samrat131\ColumnSortable\SortableTrait;

class User extends Model
{
    use SortableTrait;

    protected $columnToSort = [
        'id',
        'name',
        'email',
        'created_at'
    ];

```

### Controller

Use the `sortable()` method with the model like this `User::sortable()->get()` or `User::sortable()->paginate(15)`

```
<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $users = User::sortable()->get();
        return view('users.index', compact('users'));
    }
}
```
You can set default sortable param like this `User::sortable(['created_at', 'desc'])->get()`

### View

In the view blade.php file, `@sortable_column('id', 'ID')` add this view method (blade directive) with db column/field name. 1st param (required) is for database field name, 2nd param (optional) is for frontend display.

```
<tr>
    <td>@sortable_link('id', 'ID')</td>
    <td>@sortable_link('name', 'Name')</td>
    <td>@sortable_link('email', 'Email')</td>
    <td>@sortable_link('created_at', 'Created')</td>
</tr>
```

This package uses the font awesome icon for up and down arrow `fa fa-arrow-circle-down` and `fa fa-arrow-circle-up`

Thanks