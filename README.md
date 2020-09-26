# Laravel Column Sortable

Sort laravel model view list by database column or field wise

## Installation

To use cloumn-sortable in your project, please use Composer to add the package to your laravel applications

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
        'id'=>'ID',
        'name'=>'Name',
        'email'=>'Email',
        'created_at'=>'Created'
    ];

```

### Controller

Use the `sorting()` method with the model like this `User::sorting()->get()` or `User::sorting()->paginate(15)`

```
<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $users = User::sorting()->get();
        return view('home', compact('users'));
    }
}
```

### View

In the view blade.php file, `@sortable_column('id')` add this view method (blade directive) with db column/field name.

```
<tr>
    <td>@sortable_column('id')</td>
    <td>@sortable_column('name')</td>
    <td>@sortable_column('email')</td>
    <td>@sortable_column('created_at')</td>
</tr>
```