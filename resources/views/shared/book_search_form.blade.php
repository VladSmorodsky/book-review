<form action="{{ route('books.index') }}" method="GET" class="flex mb-4 items-center">
    <input type="text" name="title" placeholder="Search by title" class="input h-10"
           value="{{ request('title') }}"/>
    <input type="hidden" name="filter" value="{{ request('filter') }}">
    <button type="submit" class="btn btn-primary h-10">Search</button>
    <a href="{{ route('books.index') }}" class="btn btn-secondary h-10">Reset</a>
</form>
