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
                    </tr>
                </x-table.thead>
                <tbody>
                    @foreach ($questions->where('is_draft', true) as $question)
                        <x-table.tr>
                            <x-table.td>
                                <div class="flex flex-row justify-between">
                                    <span>{{ $question->question }}</span>
                                    <div>
                                        <x-form :action="route('question.publish', $question)" method="PUT">
                                            <button type="submit" class="hover:underline text-blue-500">
                                                Publish
                                            </button>
                                        </x-form>
                                        <a href="{{ route('question.edit', $question) }}" class="hover:underline text-blue-500">
                                            Edit
                                        </a>
                                        <x-form :action="route('question.archive', $question)" method="PATCH">
                                            <button type="submit" class="hover:underline text-blue-500">
                                                Archive
                                            </button>
                                        </x-form>
                                        <x-form :action="route('question.destroy', $question)" method="DELETE" onsubmit="return confirm('Are you sure?')">
                                            <button type="submit" class="hover:underline text-red-500">
                                                Remove
                                            </button>
                                        </x-form>
                                    </div>
                                </div>
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
                    </tr>
                </x-table.thead>
                <tbody>
                    @foreach ($questions->where('is_draft', false) as $question)
                        <x-table.tr>
                            <x-table.td>
                                <div class="flex flex-row justify-between">
                                    <span>{{ $question->question }}</span>
                                    <div>
                                        <x-form :action="route('question.archive', $question)" method="PATCH">
                                            <button type="submit" class="hover:underline text-blue-500">
                                                Archive
                                            </button>
                                        </x-form>
                                        <x-form :action="route('question.destroy', $question)" method="DELETE" onsubmit="return confirm('Are you sure?')">
                                            <button type="submit" class="hover:underline text-red-500">
                                                Remove
                                            </button>
                                        </x-form>
                                    </div>
                                </div>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>
            </x-table>
        </div>

        <hr class="border-gray-700 border-dashed my-4">

        <div class="dark:text-gray-200 uppercase font-bold mb-1">
            Archived Questions
        </div>

        <div class="dark:text-gray-400 space-y-4">
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Question</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                    @foreach ($archivedQuestions as $question)
                        <x-table.tr>
                            <x-table.td>
                                <div class="flex flex-row justify-between">
                                    <span>{{ $question->question }}</span>
                                    <div>
                                        <x-form :action="route('question.restore', $question)" method="PATCH">
                                            <button type="submit" class="hover:underline text-blue-500">
                                                Restore
                                            </button>
                                        </x-form>
                                        <x-form :action="route('question.destroy', $question)" method="DELETE" onsubmit="return confirm('Are you sure?')">
                                            <button type="submit" class="hover:underline text-red-500">
                                                Remove
                                            </button>
                                        </x-form>
                                    </div>
                                </div>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>
            </x-table>
        </div>
    </x-container>
</x-app-layout>
