<x-app-layout>
    <x-slot name="header">
        Register Pendapatan
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow-sm border border-emerald-100 sm:rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow-sm border border-emerald-100 sm:rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow-sm border border-emerald-100 sm:rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>