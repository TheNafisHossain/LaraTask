@extends('layouts.app')

@section('content')
    <div class="flex relative justify-between p-5">
        @if (!$projects->count())
            <div
                class="absolute top-0 bottom-0 left-0 right-0 text-center grid place-items-center bg-white/30 backdrop-blur"
            >
                <h2 class="text-2xl font-bold tracking-light text-gray-900 mb-9">Please <a href="{{ route('projects.create') }}" class="cursor-pointer underline underline-offset-4 decoration-2 decoration-indigo-500 transition hover:text-indigo-500">create a project</a> first</h2>
            </div>
        @endif

        <div class="flex-auto">
            <h1 class="ext-4xl font-bold tracking-tight text-gray-900 mb-4 sm:text-6xl">Tasks</h1>
            <a href="{{ route('index') }}" class="cursor-pointer underline underline-offset-4 decoration-2 decoration-indigo-500 transition hover:text-indigo-500">Go back</a>
        </div>

        <form class="flex-auto sm:col-span-3" action="@isset($task) {{ route('tasks.update', $task) }} @else {{ route('tasks.create') }} @endisset" method="POST">
            @csrf
            @isset($task)
                @method('PUT')
            @endisset

            <div class="mb-4">
                <label for="title" class="block mb-1 font-medium leading-6 text-gray-900">Title</label>

                <input
                    required
                    type="text"
                    name="title"
                    id="title"
                    class="block w-1/3 rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    @isset($task) value="{{ $task->title }}" @endisset
                />
            </div>

            <div class="my-3">
                <label for="project" class="block mb-1 font-medium leading-6 text-gray-900">Project</label>

                <select
                    required
                    name="project"
                    id="project"
                    class="block w-1/3 rounded-md border-0 p-3 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                >
                    <option value="">Select a project</option>
                    
                    @foreach ($projects as $project)
                        <option
                            value="{{ $project->id }}"
                            @if(isset($task) && $project->id === $task->project->id) selected @endif
                        >
                            {{ $project->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button
                type="submit"
                class="rounded-md mt-5 bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow transition hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:shadow-lg"
            >
                {{ isset($task) ? "Update" : "Add" }} Task
            </button>
        </form>
    </div>
@endsection