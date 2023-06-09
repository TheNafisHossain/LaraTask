@extends('layouts.app')

@section('content')
    <div class="flex justify-between">
        <div class="flex-auto">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl mb-8">Projects</h1>
            <a href="{{ route('index') }}" class="cursor-pointer underline underline-offset-4 decoration-2 decoration-indigo-500 transition hover:text-indigo-500">Go back</a>
        </div>

        <form class="flex-auto sm:col-span-3" action="@isset($project) {{ route('projects.update', $project) }} @else {{ route('projects.create') }} @endisset" method="POST">
            @csrf
            @isset($project)
                @method('PUT')
            @endisset

            <div class="mb-4">
                <label for="title" class="block mb-1 font-medium leading-6 text-gray-900">Title</label>

                <input
                    required
                    type="text"
                    name="title"
                    class="block w-1/3 rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    @isset($project) value="{{ $project->title }}" @endisset
                />
            </div>
                
            <button
                type="submit"
                class="rounded-md mt-5 bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow transition hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:shadow-lg"
            >
                Add Project
            </button>
        </form>
    </div>
@endsection