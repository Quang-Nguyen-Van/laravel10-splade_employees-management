<x-admin-layout>
    <h1 class="text-2x1 font-semibold p-4">Edit Permission</h1>
    {{-- <x-splade-form :for="$form">
    </x-splade-form> --}}

    <x-splade-form :default="$permission" :action="route('admin.permissions.update', $permission)" method="PUT" class="p-4 bg-white rounded-md space-y-3">
        <x-splade-input name="name" :label="__('Name')" />
        <x-splade-select name="roles[]" :options="$roles" multiple relation choices :label="__('Roles')" />
        <x-splade-submit />
    </x-splade-form>
</x-admin-layout>
