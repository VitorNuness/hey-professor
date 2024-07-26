<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('My Questions') }}
        </x-header>
    </x-slot>

    <x-container>
        <x-form :action="route('question.store')" method="POST">
            <x-textarea label="Question" name="question" placeholder="Ask me anything..." />
            <x-btn.primary>Save</x-btn.primary>
            <x-btn.reset>Cancel</x-btn.reset>
        </x-form>

        <hr class="border-gray-700 border-dashed my-4">

        <div class="dark:text-gray-200 uppercase font-bold mb-1">
            My Drafts
        </div>

        <div class="dark:text-gray-400 space-y-4">
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Question</x-table.th>
                        <x-table.th>Actions</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                    @foreach ($questions->where('is_draft', true) as $question)
                        <x-table.tr>
                            <x-table.td>{{ $question->question }}</x-table.td>
                            <x-table.td>
                                <x-form :action="route('question.publish', $question)" method="PUT">
                                    <button type="submit" class="hover:underline text-blue-500 mb-4">
                                        Publish
                                    </button>
                                </x-form>
                                <x-form :action="route('question.destroy', $question)" method="DELETE">
                                    <button type="submit" class="hover:underline text-red-500">
                                        Remove
                                    </button>
                                </x-form>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>
            </x-table>
        </div>

        <hr class="border-gray-700 border-dashed my-4">

        <div class="dark:text-gray-200 uppercase font-bold mb-1">
            My Questions
        </div>

        <div class="dark:text-gray-400 space-y-4">
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Question</x-table.th>
                        <x-table.th>Actions</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                    @foreach ($questions->where('is_draft', false) as $question)
                        <x-table.tr>
                            <x-table.td>{{ $question->question }}</x-table.td>
                            <x-table.td>
                                <x-form :action="route('question.destroy', $question)" method="DELETE">
                                    <button type="submit" class="hover:underline text-red-500">
                                        Remove
                                    </button>
                                </x-form>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>
            </x-table>
        </div>
    </x-container>
</x-app-layout>
