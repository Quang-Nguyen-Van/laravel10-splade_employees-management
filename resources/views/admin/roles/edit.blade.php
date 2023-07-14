<x-admin-layout>
    <h1 class="text-2x1 font-semibold p-4">Edit Role</h1>
    {{-- <x-splade-form :for="$form"></x-splade-form> --}}

    <x-splade-form :default="$role" :action="route('admin.roles.update', $role)" method="PUT" class="p-4 bg-white rounded-md space-y-3">
        <x-splade-input name="name" :label="__('Name')" />
        <x-splade-select name="permissions[]" :options="$permissions" multiple relation choices :label="__('Permissions')" />
        <x-splade-submit />
    </x-splade-form>
</x-admin-layout>
