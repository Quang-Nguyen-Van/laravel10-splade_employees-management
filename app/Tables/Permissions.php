<?php

namespace App\Tables;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\AbstractTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Excel;
use ProtoneMedia\Splade\Facades\Toast;

class Permissions extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%");
                });
            });
        });

        return QueryBuilder::for(Permission::where('name', '!=', 'admin'))
            ->defaultSort('id')
            ->allowedSorts(['id', 'name'])
            ->AllowedFilters(['id', 'name', $globalSearch]);
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $table
            ->withGlobalSearch(columns: ['name'])
            ->column('id', sortable: true)
            ->column('name', sortable: true)
            ->column('action', exportAs: false)
            ->bulkAction(
                label: 'Delete Permissions',
                each: fn (Permission $permission) => $permission->delete(),
                after: fn () => Toast::info('Permissions Deleted')
            )
            ->export(label: 'CSV Export', filename: 'permission.csv', type: Excel::CSV)
            ->paginate(15);
    }
}
