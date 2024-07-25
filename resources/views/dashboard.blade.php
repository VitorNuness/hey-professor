<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Dashboard') }}
        </x-header>
    </x-slot>

    <x-container>
        <x-form :action="route('question.store')" method="POST">
            <x-textarea label="Question" name="question" placeholder="Ask me anything..." />
            <x-btn.primary>Save</x-btn.primary>
            <x-btn.reset>Cancel</x-btn.reset>
        </x-form>
    </x-container>
</x-app-layout>
