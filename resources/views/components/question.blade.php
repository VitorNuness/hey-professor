@props([
    'question',
])

<div class="rounded dark:bg-gray-800/50 bg-white shadow shadow-blue-500/30 p-3 dark:text-gray-400 flex justify-between">
    <span>
        {{ $question->question }}
    </span>
    <div class="flex flex-row gap-x-2">
        <x-form :action="route('question.like', $question)">
            <button class="flex flex-col items-center text-blue-500">
                <x-icons.thumbs-up class="w-5 h-5 text-gray-300 dark:text-blue-200/50 hover:text-blue-500 dark:hover:text-blue-500 cursor-pointer" />
                <span class="text-xs font-bold">
                    {{ $question->likes }}
                </span>
            </button>
        </x-form>
        <x-form :action="route('question.like', $question)">
            <button class="flex flex-col items-center text-red-500">
                <x-icons.thumbs-down class="w-5 h-5 text-gray-300 dark:text-red-200/50 hover:text-red-500 dark:hover:text-red-500 cursor-pointer" />
                <span class="text-xs font-bold">
                    {{ $question->unlikes }}
                </span>
            </button>
        </x-form>
    </div>
</div>
