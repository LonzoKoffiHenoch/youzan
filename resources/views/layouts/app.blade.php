<div class="min-h-screen bg-gray-100">

    <!-- Page Content -->
    <main>
        <div class="flex">
            <x-side-bar/>

            <div class="flex-1">
                @include('layouts.navigation')
                <div class="px-[74px]">
                    {{ $slot }}
                </div>
            </div>
        </div>

    </main>
</div>
