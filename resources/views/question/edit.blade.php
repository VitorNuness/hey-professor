<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Edit Question') }} :: {{ $question->id }}
        </x-header>
    </x-slot>

    <x-container>
        <x-form :action="route('question.update', $question)" method="PUT">
            <x-textarea label="Question" name="question" placeholder="Ask me anything..." :value="$question->question" />
            <x-btn.primary>Save</x-btn.primary>
            <x-btn.back :to="route('question.index')" />
        </x-form>
    </x-container>
</x-app-layout>
