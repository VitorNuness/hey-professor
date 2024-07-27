<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Vote for a question') }}
        </x-header>
    </x-slot>

    <x-container>
        <div class="dark:text-gray-400 space-y-4">
            <x-search :action="route('dashboard')" placeholder="Search for a question" />

            @forelse ($questions as $item)
                <x-question :question="$item" />
            @empty
                <div class="dark:text-gray-300 text-center flex flex-col justify-center items-center gap-4 p-8">
                    <x-draws.not-found class="w-96" />
                    <p>Ops! Don't find any question with have "<span class="font-bold">{{ request()->search }}</span>".</p>
                </div>
            @endforelse

            {{ $questions->withQueryString()->links() }}
        </div>
    </x-container>
</x-app-layout>
