<x-admin-layout>
    <h1 class="text-2x1 font-semibold p-4">New Country</h1>
    <x-splade-form :action=" route('admin.countries.store')" method="POST" class="p-4 bg-white rounded-md space-y-3">
        <x-splade-input name="country_code" :label="__('Country code')" />
        <x-splade-input name="name" :label="__('Name')" />
        <x-splade-submit />
    </x-splade-form>
</x-admin-layout>
