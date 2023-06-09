@extends('layouts.app')

@section('content')
    <div class="flex justify-between">
        <div class="flex-auto p-3">
            <div class="mb-8">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl mb-8">Projects</h1>
                
                <a
                    href="{{ route('projects.create') }}"
                    class="cursor-pointer underline underline-offset-4 decoration-2 decoration-indigo-500 transition hover:text-indigo-500"
                >
                    Create new project
                </a>

                @if (Request::get('project'))
                    <a
                        href="/"
                        class="rounded-md ml-5 bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow transition hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:shadow-lg"
                    >
                        Deselect Project
                    </a>
                @endif
            </div>

            <ul role="list">
                @foreach ($projects as $project)
                    <li
                        class="flex items-center border-2 border-gray-100 justify-between mb-5 py-3 px-4 w-4/6 bg-gray-100 rounded-lg shadow transition hover:bg-gray-200 hover:border-gray-200 hover:shadow-lg cursor-pointer @if (Request::get('project') == $project->id) border-indigo-500 @endif"
                    >
                        <a href="?project={{ $project->id }}" class="flex flex-1 gap-x-4">
                            <p class="text font-semibold leading-6 text-gray-900">
                                {{ $project->title }}
                            </p>
                            <p class="text-sm leading-6 text-gray-500">{{ $project->tasks->count() }} tasks</p>
                        </a>

                        <div class="flex items-end">
                            <a
                                href="{{ route('projects.edit', $project) }}"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow transition hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:shadow-lg"
                            >
                                Edit
                            </a>

                            <form action="{{ route('projects.delete', $project) }}" method="POST">
                                @csrf
                                @method('delete')

                                <button
                                    onclick="return confirm('Are you sure?');"
                                    type="submit"
                                    class="rounded-md ml-2 bg-rose-600 px-3 py-2 text-sm font-semibold text-white shadow transition hover:bg-rose-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-600 hover:shadow-lg"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="flex-auto relative p-3">
            @if (!$projects->count())
                <div
                    class="absolute top-0 bottom-0 left-0 right-0 text-center grid place-items-center bg-white/30 backdrop-blur"
                >
                    <h2 class="text-2xl font-bold tracking-light text-gray-900 mb-9">Please <a href="{{ route('projects.create') }}" class="cursor-pointer underline underline-offset-4 decoration-2 decoration-indigo-500 transition hover:text-indigo-500">create a project</a> first</h2>
                </div>
            @endif

            <div class="mb-8">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 mb-8 sm:text-6xl">Tasks</h1>

                <a
                    href="{{ route('tasks.create') }}"
                    class="cursor-pointer underline underline-offset-4 decoration-2 decoration-indigo-500 transition hover:text-indigo-500"
                >
                    Create new task
                </a>
            </div>

            <ul role="list" @if (!Request::get('project')) id="sortable" @endif>
                @foreach ($tasks as $task)
                    <li
                        id="{{ $task->id }}"
                        class="flex items-center justify-between mb-5 py-3 px-4 w-4/6 bg-gray-100 rounded-lg shadow transition hover:bg-gray-200 hover:shadow-lg @if (!Request::get('project')) cursor-pointer @endif"
                    >
                        <div>
                            <p class="text font-semibold leading-6 text-gray-900">
                                {{ $task->title }}
                            </p>
                            <p class="text-sm leading-6 text-gray-500">{{ $task->project->title }}</p>
                        </div>

                        <div class="flex items-end">
                            <a
                                href="{{ route('tasks.edit', $task) }}"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow transition hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:shadow-lg"
                            >
                                Edit
                            </a>

                            <form action="{{ route('tasks.delete', $task) }}" method="POST">
                                @csrf
                                @method('delete')

                                <button
                                    onclick="return confirm('Are you sure?');"
                                    type="submit"
                                    class="rounded-md ml-2 bg-rose-600 px-3 py-2 text-sm font-semibold text-white shadow transition hover:bg-rose-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-600 hover:shadow-lg"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            $('#sortable').sortable({
                ghostClass: 'bg-indigo-100',
                onEnd: function (evt) {
                    var sortedItems = [];

                    $('#sortable li').each(function() {
                        sortedItems.push($(this).attr('id'));
                    });

                    $.ajax({
                        url: '/tasks/update-priorities',
                        method: 'PUT',
                        data: { sortedItems },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
@endpush
