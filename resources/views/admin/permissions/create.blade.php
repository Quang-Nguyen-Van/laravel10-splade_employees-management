<x-admin-layout>
    <h1 class="text-2x1 font-semibold p-4">New Permission</h1>
    {{-- <x-splade-form :for="$form">
    </x-splade-form> --}}

    <x-splade-form :action=" route('admin.permissions.store')" method="POST" class="p-4 bg-white rounded-md space-y-3">
        <x-splade-input name="name" :label="__('Name')" />
        <x-splade-select name="roles[]" :options="$roles" multiple relation choices :label="__('Roles')"/>
        <x-splade-submit />
    </x-splade-form>
</x-admin-layout>
